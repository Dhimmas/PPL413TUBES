<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-800 min-h-screen">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="backdrop-blur-lg bg-white/10 border border-white/10 shadow-xl sm:rounded-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @php
                        $features = [
                            ['title' => 'Profil Pribadi', 'desc' => 'Lihat dan ubah informasi diri kamu.', 'icon' => '👤', 'color' => 'from-blue-500 to-blue-600'],
                            ['title' => 'Forum Diskusi', 'desc' => 'Diskusi bersama teman dan dosen.', 'icon' => '💬', 'color' => 'from-green-500 to-green-600'],
                            ['title' => 'Dashboard', 'desc' => 'Beranda utama aplikasi Studify.', 'icon' => '📊', 'color' => 'from-purple-500 to-purple-600'],
                            ['title' => 'To-Do List', 'desc' => 'Kelola daftar tugas harianmu.', 'icon' => '📝', 'color' => 'from-yellow-500 to-yellow-600'],
                            ['title' => 'Progress Tracker', 'desc' => 'Pantau perkembangan belajarmu.', 'icon' => '📈', 'color' => 'from-red-500 to-red-600'],
                            ['title' => 'Study Goal', 'desc' => 'Tetapkan dan capai tujuan belajar.', 'icon' => '🎯', 'color' => 'from-pink-500 to-pink-600'],
                        ];
                    @endphp

                    @foreach ($features as $feature)
                        <div
                            class="rounded-2xl bg-gradient-to-br {{ $feature['color'] }} text-white p-6 shadow-lg transition duration-300 transform hover:scale-[1.03] hover:shadow-xl hover:shadow-white/20 cursor-pointer group">
                            <div class="flex items-start gap-4">
                                <div class="text-4xl group-hover:rotate-6 transition-transform duration-300">{{ $feature['icon'] }}</div>
                                <div>
                                    <h3 class="text-xl font-bold mb-1">{{ $feature['title'] }}</h3>
                                    <p class="text-sm opacity-90">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
