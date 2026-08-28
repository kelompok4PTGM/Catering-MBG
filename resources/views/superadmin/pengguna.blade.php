@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-sm border border-orange-100 p-4 h-fit">
            <h3 class="text-lg font-bold text-textcolor mb-4 pb-2 border-b">Menu Superadmin</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('superadmin.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">📊 Dashboard</a></li>
                <li><a href="{{ route('superadmin.pengguna') }}" class="block px-4 py-2 rounded-md bg-orange-50 text-primary font-medium">👥 Kelola Pengguna</a></li>
                <li><a href="{{ route('superadmin.catering') }}" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">🏪 Semua Catering</a></li>
                <li><a href="{{ route('superadmin.pesanan') }}" class="block px-4 py-2 rounded-md hover:bg-gray-50 text-gray-700 transition">📦 Semua Pesanan</a></li>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg shadow-sm border border-orange-100 p-6">
            <h2 class="text-2xl font-bold text-textcolor mb-6">👥 Kelola Pengguna</h2>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-2">ID</th>
                            <th class="p-2">Username</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-t">
                            <td class="p-2">{{ $user->id }}</td>
                            <td class="p-2 font-medium">{{ $user->username }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $user->role == 'Superadmin' ? 'bg-purple-100 text-purple-800' : 
                                       ($user->role == 'Admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-2">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $user->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection