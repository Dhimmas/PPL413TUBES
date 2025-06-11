document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('userSearch');
    const userRows = document.querySelectorAll('.user-row');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            userRows.forEach(row => {
                const userName = row.querySelector('.user-name').textContent.toLowerCase();
                const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Modal functionality
    const modal = document.getElementById('confirmModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalCancel = document.getElementById('modalCancel');
    const modalConfirm = document.getElementById('modalConfirm');
    
    let currentAction = null;
    let currentUserId = null;
    
    function showModal(title, message, action, userId) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        currentAction = action;
        currentUserId = userId;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal() {
        modal.classList.remove('show');
        document.body.style.overflow = '';
        currentAction = null;
        currentUserId = null;
    }
    
    // Toggle Super Admin Status
    document.querySelectorAll('.btn-toggle-admin').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userRow = this.closest('.user-row');
            const statusBadge = userRow.querySelector('.status-badge');
            const isCurrentlyAdmin = statusBadge.classList.contains('super-admin');
            
            const action = isCurrentlyAdmin ? 'remove super admin' : 'make super admin';
            const title = isCurrentlyAdmin ? 'Remove Super Admin' : 'Make Super Admin';
            const message = `Are you sure you want to ${action} privileges for this user?`;
            
            showModal(title, message, 'toggle-admin', userId);
        });
    });
    
    // Delete User
    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            showModal(
                'Delete User',
                'Are you sure you want to delete this user? This action cannot be undone.',
                'delete-user',
                userId
            );
        });
    });
    
    // Modal event listeners
    modalCancel.addEventListener('click', hideModal);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            hideModal();
        }
    });
    
    modalConfirm.addEventListener('click', function() {
        if (currentAction && currentUserId) {
            if (currentAction === 'toggle-admin') {
                toggleSuperAdmin(currentUserId);
            } else if (currentAction === 'delete-user') {
                deleteUser(currentUserId);
            }
        }
        hideModal();
    });
    
    // AJAX Functions
    function toggleSuperAdmin(userId) {
        fetch(`/super-admin/users/${userId}/toggle-admin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const userRow = document.querySelector(`[data-user-id="${userId}"]`);
                const statusBadge = userRow.querySelector('.status-badge');
                
                if (data.is_super_admin) {
                    statusBadge.textContent = 'Super Admin';
                    statusBadge.className = 'status-badge super-admin';
                } else {
                    statusBadge.textContent = 'User';
                    statusBadge.className = 'status-badge regular';
                }
                
                showNotification(data.message, 'success');
            } else {
                showNotification(data.error, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        });
    }
    
    function deleteUser(userId) {
        fetch(`/super-admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const userRow = document.querySelector(`[data-user-id="${userId}"]`);
                userRow.remove();
                showNotification(data.message, 'success');
            } else {
                showNotification(data.error, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        });
    }
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        // Add styles
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '16px 24px',
            borderRadius: '12px',
            color: 'white',
            fontWeight: '600',
            zIndex: '10000',
            transform: 'translateX(100%)',
            transition: 'transform 0.3s ease',
            backgroundColor: type === 'success' ? '#10b981' : '#ef4444'
        });
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
});
