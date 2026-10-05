@extends('admin.layouts.app')

@section('title', 'Manajemen Menu Navigasi Portal')

@section('content')
<div class="space-y-6" x-data="{
    editing: false,
    editId: null,
    editName: '',
    editType: 'page',
    editPageId: '',
    editUrl: '',
    editParentId: '',
    editTarget: '_self',
    editSortOrder: 0,
    editIsActive: true,
    formAction: '{{ route('admin.menus.store') }}',
    formMethod: 'POST',

    initEdit(item) {
        this.editing = true;
        this.editId = item.id;
        this.editName = item.name;
        this.editType = item.type;
        this.editPageId = item.page_id || '';
        this.editUrl = item.url || '';
        this.editParentId = item.parent_id || '';
        this.editTarget = item.target || '_self';
        this.editSortOrder = item.sort_order || 0;
        this.editIsActive = item.is_active;
        this.formAction = '/admin/menus/' + item.id;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    resetForm() {
        this.editing = false;
        this.editId = null;
        this.editName = '';
        this.editType = 'page';
        this.editPageId = '';
        this.editUrl = '';
        this.editParentId = '';
        this.editTarget = '_self';
        this.editSortOrder = 0;
        this.editIsActive = true;
        this.formAction = '{{ route('admin.menus.store') }}';
    }
}">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Menu Navigasi Portal</h2>
            <p class="text-xs text-slate-500 mt-1">Atur tautan navbar header publik, buat submenu bertingkat (dropdown), dan tautkan ke halaman statis desa.</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200 transition space-x-1 border border-slate-300">
                <span>🌐</span>
                <span>Lihat Hasil di Portal</span>
            </a>
        </div>
    </div>

    <!-- Layout: Form (1/3) & List Tree (2/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah / Edit Menu -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 h-fit">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-800 text-sm flex items-center space-x-2">
                    <span x-text="editing ? '✏️' : '➕'"></span>
                    <span x-text="editing ? 'Edit Item Menu' : 'Tambah Menu Baru'"></span>
                </h3>
                <button type="button" x-show="editing" @click="resetForm()" class="text-xs text-rose-600 hover:underline">
                    Batal Edit
                </button>
            </div>

            <form :action="formAction" method="POST" class="space-y-4">
                @csrf
                <template x-if="editing">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <input type="hidden" name="location" value="header">

                <!-- Label / Nama Menu -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Nama Menu / Label <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        x-model="editName"
                        required 
                        placeholder="Contoh: Profil Desa, Visi Misi"
                        class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    >
                </div>

                <!-- Tipe Menu -->
                <div x-data="{ type: 'page' }" x-init="$watch('editType', val => type = val)">
                    <label for="type" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Tipe Tautan <span class="text-rose-500">*</span>
                    </label>
                    <select id="type" name="type" x-model="editType" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="page">📄 Halaman Statis Desa</option>
                        <option value="route">🔗 Rute Sistem Internal (/berita, dsb)</option>
                        <option value="custom">🌐 URL Eksternal / Kustom</option>
                    </select>

                    <!-- Pilihan Halaman Statis jika type = page -->
                    <div class="mt-3" x-show="editType === 'page'">
                        <label for="page_id" class="block text-xs font-medium text-slate-600 mb-1">
                            Pilih Halaman Statis
                        </label>
                        <select id="page_id" name="page_id" x-model="editPageId" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">-- Pilih Halaman --</option>
                            @foreach($staticPages as $page)
                                <option value="{{ $page->id }}">{{ $page->title }} (/halaman/{{ $page->slug }})</option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">URL akan dihubungkan secara otomatis ke rute halaman yang dipilih.</p>
                    </div>

                    <!-- Input URL Manual jika type = route atau custom -->
                    <div class="mt-3" x-show="editType !== 'page'">
                        <label for="url" class="block text-xs font-medium text-slate-600 mb-1">
                            URL Tujuan
                        </label>
                        <input 
                            type="text" 
                            id="url" 
                            name="url" 
                            x-model="editUrl"
                            placeholder="Contoh: /berita atau https://..."
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>

                <!-- Menu Induk (Parent) -->
                <div>
                    <label for="parent_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                        Menu Induk (Submenu)
                    </label>
                    <select id="parent_id" name="parent_id" x-model="editParentId" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Menu Utama (Level 1) --</option>
                        @foreach($parentMenus as $parent)
                            <option value="{{ $parent->id }}">↳ {{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">Pilih menu induk jika item ini merupakan dropdown submenu.</p>
                </div>

                <!-- Target & Urutan -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="target" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Target
                        </label>
                        <select id="target" name="target" x-model="editTarget" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="_self">Tab Sama (_self)</option>
                            <option value="_blank">Tab Baru (_blank)</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-bold text-slate-700 uppercase mb-1">
                            Urutan
                        </label>
                        <input 
                            type="number" 
                            id="sort_order" 
                            name="sort_order" 
                            x-model="editSortOrder"
                            min="0"
                            class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        >
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="pt-2">
                    <label class="inline-flex items-center space-x-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" x-model="editIsActive" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <span class="font-medium">Tampilkan di Portal (Aktif)</span>
                    </label>
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700 transition shadow-sm">
                        <span x-text="editing ? 'Simpan Perubahan' : 'Tambahkan Menu'"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tree List Menu Navigasi -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-sm">Struktur Menu Header Portal</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Tampilan urutan link navigasi utama dari kiri ke kanan.</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200">
                        {{ $menus->count() }} Menu Utama
                    </span>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($menus as $menu)
                        <div class="p-5 hover:bg-slate-50/50 transition">
                            <!-- Root Item -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold flex items-center justify-center font-mono">
                                        #{{ $menu->sort_order }}
                                    </span>
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="font-bold text-slate-800 text-sm">{{ $menu->name }}</span>
                                            @if($menu->children->isNotEmpty())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                    ▼ Dropdown ({{ $menu->children->count() }})
                                                </span>
                                            @endif
                                            @if(!$menu->is_active)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-500">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-400 font-mono mt-0.5 flex items-center space-x-2">
                                            <span>{{ $menu->resolved_url }}</span>
                                            <span>•</span>
                                            <span class="capitalize text-slate-500">{{ $menu->type }}</span>
                                            @if($menu->target === '_blank')
                                                <span>•</span>
                                                <span class="text-purple-600">Tab Baru</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <button 
                                        type="button" 
                                        @click="initEdit({{ json_encode($menu) }})"
                                        class="p-1.5 text-slate-400 hover:text-amber-600 transition" 
                                        title="Edit Menu"
                                    >
                                        ✏️
                                    </button>
                                    <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Hapus menu ini beserta seluruh submenunya?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition" title="Hapus Menu">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Nested Children / Submenus -->
                            @if($menu->children->isNotEmpty())
                                <div class="mt-3 ml-9 pl-4 border-l-2 border-slate-200 space-y-2">
                                    @foreach($menu->children as $child)
                                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-200/60 text-xs">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-mono text-slate-400">↳ #{{ $child->sort_order }}</span>
                                                <span class="font-semibold text-slate-700">{{ $child->name }}</span>
                                                <span class="font-mono text-slate-400 text-[11px]">({{ $child->resolved_url }})</span>
                                                @if(!$child->is_active)
                                                    <span class="text-[10px] text-slate-400 italic">(Nonaktif)</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <button 
                                                    type="button" 
                                                    @click="initEdit({{ json_encode($child) }})"
                                                    class="text-slate-400 hover:text-amber-600 transition"
                                                    title="Edit Submenu"
                                                >
                                                    ✏️
                                                </button>
                                                <form action="{{ route('admin.menus.destroy', $child) }}" method="POST" onsubmit="return confirm('Hapus submenu ini?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition" title="Hapus Submenu">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400">
                            <div class="text-4xl mb-3">🧭</div>
                            <p class="text-sm font-semibold text-slate-600">Belum ada menu navigasi terdaftar</p>
                            <p class="text-xs text-slate-400 mt-1">Tambahkan menu pertama dari form di sebelah kiri.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
