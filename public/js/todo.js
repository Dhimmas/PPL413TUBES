// Handle centang tugas
document.querySelectorAll('input[type="checkbox"][data-task-id]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const taskId = this.dataset.taskId;
        const completed = this.checked;
        
        fetch(`/todos/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ completed })
        });
    });
});

// Handle hapus tugas
document.querySelectorAll('.delete-task').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Yakin hapus tugas ini?')) {
            fetch(`/todos/${this.dataset.taskId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(() => this.closest('.flex').remove());
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Format waktu 24 jam
    const timeInputs = document.querySelectorAll('input[type="time"]');
    timeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value) {
                const [hours, minutes] = this.value.split(':');
                this.value = `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
            }
        });
    });
});