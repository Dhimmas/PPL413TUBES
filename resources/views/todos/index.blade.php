<x-app-layout>
@include('layouts.navigation')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Schedule</h1>
    
    <!-- Kalender -->
    @include('todos.partials.schedule')
    
    <!-- Daftar Tugas -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">Tasks</h2>
        <div class="bg-white rounded-lg shadow p-6">
            @include('todos.partials.task-list')
            
            <!-- Form Tambah Tugas -->
            <form action="{{ route('todos.store') }}" method="POST" class="mt-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> <!-- Ubah dari 4 kolom ke 3 -->
                    <!-- Ganti Judul menjadi Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <input type="text" name="title" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                               placeholder="Masukkan kategori tugas">
                    </div>
                    
                    <!-- Input Tanggal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="date" value="{{ $selectedDate }}" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    
                    <!-- Input Waktu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Waktu (opsional)</label>
                        <input type="time" 
                               name="time" 
                               id="task-time"
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-2 pr-12 py-2 sm:text-sm border-gray-300 rounded-md"
                               min="00:00"
                               max="23:59"
                               step="300"
                               value="{{ old('time', '12:30') }}">
                    </div>
                </div>
                
                <!-- Deskripsi -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" rows="2" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                              placeholder="Tambahkan deskripsi tugas"></textarea>
                </div>
                
                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Tambah Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>