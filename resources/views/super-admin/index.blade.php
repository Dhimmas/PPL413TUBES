<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Super Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Super Admin Custom Styles */
        .super-admin-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            background-attachment: fixed;
        }
        
        .glass-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.95), rgba(17, 24, 39, 0.95));
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
        
        .admin-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
        }
        
        .user-avatar {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .status-super-admin {
            background: rgba(139, 92, 246, 0.2);
            color: #8b5cf6;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        .status-regular {
            background: rgba(75, 85, 99, 0.3);
            color: #d1d5db;
            border: 1px solid rgba(75, 85, 99, 0.5);
        }
        
        .modal-overlay {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .notification.success {
            background: #10b981;
        }
        
        .notification.error {
            background: #ef4444;
        }
        
        .notification.show {
            transform: translateX(0);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="super-admin-container">
        <!-- Navigation Bar -->
        <nav class="bg-gradient-to-r from-white/10 via-white/5 to-white/10 backdrop-blur-xl border-b border-white/20 sticky top-0 z-40 shadow-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-sm">S</span>
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-300 to-purple-300 bg-clip-text text-transparent">Studify Admin</span>
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3 text-white/90">
                            @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile->profile_picture) }}" 
                                     alt="Profile" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-white/30">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-blue-500 flex items-center justify-center border-2 border-white/30">
                                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-white/60">Super Admin</div>
                            </div>
                        </div>
                        
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white/90 hover:text-white rounded-lg transition-all duration-200 font-medium">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="glass-card admin-header p-8 mb-8">
                <div class="flex justify-between items-center flex-wrap gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">User Management</h1>
                            <p class="text-gray-300">Manage user permissions and access levels</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-400">{{ $users->total() }}</div>
                            <div class="text-gray-300 text-sm">Total Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-400">{{ $users->where('is_super_admin', true)->count() }}</div>
                            <div class="text-gray-300 text-sm">Super Admins</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="glass-card overflow-hidden">
                <!-- Table Header -->
                <div class="p-6 border-b border-gray-700/50">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">All Users</h2>
                        <div class="relative">
                            <input type="text" id="userSearch" placeholder="Search users..." 
                                   class="pl-10 pr-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Joined</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody" class="divide-y divide-gray-700/50">
                            @foreach($users as $user)
                            <tr data-user-id="{{ $user->id }}" class="user-row hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $user->name }}</div>
                                            @if($user->id === Auth::id())
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-500/20 text-blue-300 rounded-full">You</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge {{ $user->is_super_admin ? 'status-super-admin' : 'status-regular' }}">
                                        {{ $user->is_super_admin ? 'Super Admin' : 'User' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->id !== Auth::id())
                                        <div class="flex space-x-2">
                                            <button class="btn-toggle-admin px-3 py-2 bg-green-500/20 text-green-400 hover:bg-green-500/30 rounded-lg transition-all duration-200 text-sm font-medium" 
                                                    data-user-id="{{ $user->id }}" 
                                                    title="{{ $user->is_super_admin ? 'Remove Super Admin' : 'Make Super Admin' }}">
                                                {{ $user->is_super_admin ? 'Remove Admin' : 'Make Admin' }}
                                            </button>
                                            <button class="btn-delete-user px-3 py-2 bg-red-500/20 text-red-400 hover:bg-red-500/30 rounded-lg transition-all duration-200 text-sm font-medium" 
                                                    data-user-id="{{ $user->id }}" 
                                                    title="Delete User">
                                                Delete
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-sm italic">Cannot modify own account</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-700/50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center">
        <div class="glass-card max-w-md w-full mx-4 transform scale-90 transition-transform">
            <div class="p-6">
                <h3 id="modalTitle" class="text-lg font-semibold text-white mb-4">Confirm Action</h3>
                <p id="modalMessage" class="text-gray-300 mb-6">Are you sure you want to perform this action?</p>
                <div class="flex justify-end space-x-3">
                    <button id="modalCancel" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">Cancel</button>
                    <button id="modalConfirm" class="btn-danger px-4 py-2 text-white rounded-lg transition-all">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('userSearch');
            const userRows = document.querySelectorAll('.user-row');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                userRows.forEach(row => {
                    const userName = row.querySelector('.text-white.font-medium').textContent.toLowerCase();
                    const userEmail = row.querySelector('.text-gray-300').textContent.toLowerCase();
                    row.style.display = (userName.includes(searchTerm) || userEmail.includes(searchTerm)) ? '' : 'none';
                });
            });
            
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
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.querySelector('.glass-card').style.transform = 'scale(1)';
            }
            
            function hideModal() {
                modal.querySelector('.glass-card').style.transform = 'scale(0.9)';
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 150);
                currentAction = null;
                currentUserId = null;
            }
            
            // Event listeners
            document.querySelectorAll('.btn-toggle-admin').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    const userRow = this.closest('.user-row');
                    const statusBadge = userRow.querySelector('.status-badge');
                    const isCurrentlyAdmin = statusBadge.classList.contains('status-super-admin');
                    
                    const action = isCurrentlyAdmin ? 'remove super admin' : 'make super admin';
                    const title = isCurrentlyAdmin ? 'Remove Super Admin' : 'Make Super Admin';
                    const message = `Are you sure you want to ${action} privileges for this user?`;
                    
                    showModal(title, message, 'toggle-admin', userId);
                });
            });
            
            document.querySelectorAll('.btn-delete-user').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.dataset.userId;
                    showModal('Delete User', 'Are you sure you want to delete this user? This action cannot be undone.', 'delete-user', userId);
                });
            });
            
            modalCancel.addEventListener('click', hideModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) hideModal();
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
                        const toggleButton = userRow.querySelector('.btn-toggle-admin');
                        
                        if (data.is_super_admin) {
                            statusBadge.textContent = 'Super Admin';
                            statusBadge.className = 'status-badge status-super-admin';
                            toggleButton.textContent = 'Remove Admin';
                        } else {
                            statusBadge.textContent = 'User';
                            statusBadge.className = 'status-badge status-regular';
                            toggleButton.textContent = 'Make Admin';
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
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.textContent = message;
                document.body.appendChild(notification);
                
                setTimeout(() => notification.classList.add('show'), 100);
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>
