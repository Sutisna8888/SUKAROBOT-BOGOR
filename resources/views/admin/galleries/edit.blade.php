@extends('panel.layouts.app')

@section('title', 'Edit Foto Galeri')

@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4 sm:py-8">
    <div class="container px-4 sm:px-6 mx-auto max-w-3xl">

        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden">
            <form id="galleryForm" action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                
                <div class="p-5 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    @include('panel.partials.forms.section-header', [
                        'title' => 'Informasi Foto & Kegiatan',
                        'subtitle' => 'Perbarui judul dan kategori dokumentasi galeri',
                        'color' => 'blue',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    ])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        @include('panel.partials.forms.input-text', [
                            'name' => 'title',
                            'label' => 'Judul Kegiatan / Foto',
                            'value' => $gallery->title ?? '',
                            'placeholder' => 'Contoh: Workshop Robotika Arduino',
                            'required' => true,
                        ])

                        @php
                            $catOptions = [];
                            foreach ($categories ?? ['Kursus', 'Pelatihan', 'Go to School', 'Holiday Program'] as $c) {
                                $catOptions[$c] = $c;
                            }
                            if (!empty($gallery->category) && !isset($catOptions[$gallery->category])) {
                                $catOptions[$gallery->category] = $gallery->category;
                            }
                            $catOptions['__new__'] = '+ Tambah Kategori Baru...';
                        @endphp

                        @include('panel.partials.forms.select', [
                            'name' => 'category',
                            'id' => 'category',
                            'label' => 'Kategori',
                            'value' => $gallery->category ?? 'Kursus',
                            'options' => $catOptions,
                            'required' => false,
                        ])

                        <div id="new-category-wrapper" class="hidden">
                            @include('panel.partials.forms.input-text', [
                                'name' => 'new_category',
                                'id' => 'new_category',
                                'label' => 'Nama Kategori Baru',
                                'placeholder' => 'Ketik nama kategori baru...',
                                'required' => false,
                            ])
                        </div>

                        @include('panel.partials.forms.select', [
                            'name' => 'is_active',
                            'label' => 'Status Tampil',
                            'value' => $gallery->is_active ? '1' : '0',
                            'options' => [
                                '1' => 'Aktif (Tampil di Beranda)',
                                '0' => 'Non-Aktif (Sembunyikan)',
                            ],
                            'required' => true,
                        ])
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi Singkat (Opsional)
                        </label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all outline-none"
                            placeholder="Tuliskan keterangan singkat tentang kegiatan ini...">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                </div>

                
                <div class="p-5 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    @include('panel.partials.forms.section-header', [
                        'title' => 'File Foto Galeri',
                        'subtitle' => 'Kosongkan jika tidak ingin mengubah foto yang sudah ada',
                        'color' => 'orange',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>'
                    ])

                    <div class="mt-6">
                        @include('panel.partials.forms.image-upload-simple', [
                            'name' => 'image',
                            'label' => 'Ganti Foto',
                            'required' => false,
                            'maxSize' => 5,
                            'aspectHint' => 'Rekomendasi rasio 4:3 atau 16:9 agar proporsional',
                            'currentImage' => !empty($gallery->image) ? asset($gallery->image) : null,
                            'currentImageAlt' => 'Foto saat ini'
                        ])
                    </div>
                </div>

            </form>

            
            @include('panel.partials.forms.action-buttons', [
                'backUrl' => route('admin.galleries.index'),
                'formId' => 'galleryForm',
                'submitText' => 'Simpan Perubahan'
            ])
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/elearning/admin/js/components/simple-image-upload.js') }}?v={{ time() }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const catSelect = document.getElementById('category');
        const newCatWrapper = document.getElementById('new-category-wrapper');
        const newCatInput = document.getElementById('new_category');

        function checkCategory() {
            if (catSelect && newCatWrapper) {
                if (catSelect.value === '__new__') {
                    newCatWrapper.classList.remove('hidden');
                    if (newCatInput) newCatInput.focus();
                } else {
                    newCatWrapper.classList.add('hidden');
                }
            }
        }

        if (catSelect) {
            catSelect.addEventListener('change', checkCategory);
            checkCategory();
        }
    });
</script>
@endpush
