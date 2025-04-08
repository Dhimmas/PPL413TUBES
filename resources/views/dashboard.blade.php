<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $features = [
                            ['title' => 'Profil Pribadi', 'desc' => 'Lihat dan ubah informasi diri kamu.', 'icon' => '👤', 'color' => 'bg-blue-500'],
                            ['title' => 'Forum Diskusi', 'desc' => 'Diskusi bersama teman dan dosen.', 'icon' => '💬', 'color' => 'bg-green-500'],
                            ['title' => 'Dashboard', 'desc' => 'Beranda utama aplikasi Studify.', 'icon' => '📊', 'color' => 'bg-purple-500'],
                            ['title' => 'To-Do List', 'desc' => 'Kelola daftar tugas harianmu.', 'icon' => '📝', 'color' => 'bg-yellow-500'],
                            ['title' => 'Progress Tracker', 'desc' => 'Pantau perkembangan belajarmu.', 'icon' => '📈', 'color' => 'bg-red-500'],
                            ['title' => 'Study Goal', 'desc' => 'Tetapkan dan capai tujuan belajar.', 'icon' => '🎯', 'color' => 'bg-pink-500'],
                        ];
                    @endphp

                    @foreach ($features as $feature)
                        <div
                            class="{{ $feature['color'] }} text-white p-6 rounded-xl shadow hover:scale-105 transform transition duration-300 cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="text-3xl">{{ $feature['icon'] }}</div>
                                <div>
                                    <h3 class="text-lg font-bold mb-1">{{ $feature['title'] }}</h3>
                                    <p class="text-sm">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
