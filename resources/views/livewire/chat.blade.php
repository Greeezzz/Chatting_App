<div class="flex h-screen bg-[#1e1e2f] text-white overflow-hidden">
    <!-- Sidebar Members -->
    <div class="w-1/4 bg-[#111827] p-4 flex flex-col justify-between overflow-y-auto">
        <div>
            <h2 class="text-xl font-bold mb-4">Members</h2>
            @foreach ($memberunread as $id => $data)
                <button wire:click="pilihtujuan({{ $id }})"
                    class="w-full text-left mb-2 p-2 rounded bg-[#1f2937] hover:bg-[#374151] transition-all duration-200 {{ $tujuan_id === $id ? 'bg-blue-700 shadow-md' : '' }}">
                    {{ $data['user']->name }}
                    @if ($data['unread'] > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full float-right">{{ $data['unread'] }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Ganti Foto -->
        <form wire:submit.prevent="gantiFoto" class="mt-6 space-y-2">
            <input type="file" id="uploadProfil" wire:model="fotoProfil" class="hidden">

            <label for="uploadProfil"
                class="inline-flex items-center gap-2 bg-[#1f2937] px-3 py-2 rounded cursor-pointer hover:bg-[#374151]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span>Pilih Foto</span>
            </label>

            @if ($fotoProfil)
                <div>
                    <p class="text-sm text-gray-400">Preview:</p>
                    <img src="{{ $fotoProfil->temporaryUrl() }}" class="w-16 h-16 rounded-full ring-2 ring-blue-400">
                </div>
            @endif

            <div wire:loading wire:target="gantiFoto" class="text-sm text-gray-400">
                Mengganti foto...
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 disabled:opacity-50"
                wire:loading.attr="disabled">
                Simpan
            </button>

            @if (session()->has('success'))
                <div class="bg-green-500 p-2 rounded text-white">
                    {{ session('success') }}
                </div>
            @endif
        </form>
    </div>

    <!-- Chat Area -->
    <div class="flex flex-col w-3/4">
        <!-- Chat Box -->
        <div wire:poll.1000ms id="chat-container"
            class="flex-1 overflow-y-auto p-4 bg-[#0f172a] flex flex-col-reverse space-y-reverse space-y-4 scrollbar-thin scrollbar-thumb-[#334155] scrollbar-track-[#1e293b]">
            @if ($obrolan)
                @foreach ($obrolan->reverse()->values() as $index => $o)
                    @php
                        $showAvatar = $index === $obrolan->count() - 1 || $obrolan->values()[$obrolan->count() - $index - 2]->user_id !== $o->user_id;
                    @endphp

                    <div class="flex {{ $o->user_id === auth()->id() ? 'justify-end' : 'justify-start' }} items-end gap-2 animate-slideIn">
                        @if ($o->user_id !== auth()->id())
                            @if ($showAvatar)
                                <img src="{{ asset('storage/avatars/' . ($o->user->foto ?? 'a.png')) }}"
                                    class="w-8 h-8 rounded-full ring-2 ring-blue-400 hover:scale-105 transition-transform">
                            @else
                                <div class="w-8"></div>
                            @endif
                        @endif

                        <div class="relative max-w-xs p-3 rounded-2xl shadow transition-all duration-300 {{ $o->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-[#374151]' }}">
                            <div>
                                {{ $editPesanId === $o->id ? '' : $o->pesan }}

                                @if ($o->file)
                                    @if (Str::endsWith($o->file, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $o->file) }}" class="mt-2 rounded-lg max-w-[200px] border border-white">
                                    @else
                                        <a href="{{ asset('storage/' . $o->file) }}" target="_blank"
                                            class="block mt-2 text-sm underline">📎 Lihat File</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Input & Edit Form -->
        <div class="bg-[#111827] p-4">
            @if ($editPesanId)
                <div class="flex items-center gap-2 bg-yellow-100 p-3 rounded mb-3 text-black">
                    <input type="text" wire:model.defer="pesanEdit" class="flex-1 p-2 rounded border">
                    <button wire:click="updatePesan" class="bg-blue-500 px-3 py-1 rounded text-white hover:bg-blue-600">Simpan</button>
                    <button wire:click="$set('editPesanId', null)" class="text-gray-600 hover:text-black">Batal</button>
                </div>
            @endif

            <form wire:submit.prevent="kirimpesan" class="flex gap-2 items-end">
                <input type="text" wire:model.defer="pesan" placeholder="Tulis pesan..."
                    class="flex-1 p-2 rounded-md bg-[#1f2937] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <input type="file" id="filePesanInput" wire:model="filePesan" class="hidden">
                <label for="filePesanInput"
                    class="inline-flex items-center gap-2 bg-[#1f2937] px-3 py-2 rounded-l-md cursor-pointer hover:bg-[#374151]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span>Upload</span>
                </label>

                <div wire:loading wire:target="filePesan" class="text-sm text-gray-400">
                    Mengupload file...
                </div>

                <button type="submit"
                    class="bg-blue-600 px-4 py-2 rounded-r-md hover:bg-blue-700 transition duration-150">
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>
