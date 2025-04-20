<div class="flex h-screen bg-gradient-to-r from-[#1f2937] via-[#2a2e4e] to-[#3b3f73] text-white overflow-hidden">
    <!-- Sidebar Members -->
    <div class="w-1/4 bg-[#252b48] p-4 flex flex-col justify-between overflow-y-auto">
        <div>
            <h2 class="text-xl font-bold mb-4 text-purple-300">Members</h2>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $memberunread; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button wire:click="pilihtujuan(<?php echo e($id); ?>)"
                    class="w-full text-left mb-2 p-2 rounded bg-[#374151] hover:bg-[#4b5563] transition-all duration-200 <?php echo e($tujuan_id === $id ? 'bg-purple-700 shadow-md' : ''); ?>">
                    <?php echo e($data['user']->name); ?>

                    <!--[if BLOCK]><![endif]--><?php if($data['unread'] > 0): ?>
                        <span class="bg-pink-500 text-white text-xs px-2 py-0.5 rounded-full float-right animate-bounce"><?php echo e($data['unread']); ?></span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Ganti Foto -->
        <form wire:submit.prevent="gantiFoto" class="mt-6 space-y-4">
            <input type="file" id="uploadProfil" wire:model="fotoProfil" class="hidden">
            <label for="uploadProfil"
                class="flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 px-3 py-2 rounded-lg cursor-pointer hover:scale-105 transition-transform duration-300 ease-in-out shadow-lg hover:shadow-purple-700">
                <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
                <span class="text-white font-semibold">Pilih Foto Profil</span>
            </label>

            <!--[if BLOCK]><![endif]--><?php if($fotoProfil): ?>
                <div class="text-center animate-fade-in">
                    <p class="text-sm text-purple-200 mb-1">Preview:</p>
                    <img src="<?php echo e($fotoProfil->temporaryUrl()); ?>"
                        class="w-16 h-16 rounded-full ring-4 ring-purple-400 mx-auto shadow-lg hover:scale-110 transition-transform duration-300">
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div wire:loading wire:target="fotoProfil" class="text-sm text-gray-300 animate-pulse">
                Mengunggah foto...
            </div>

            <button type="submit"
    wire:loading.attr="disabled"
    wire:target="fotoProfil"
    class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 ease-in-out transform hover:scale-105 shadow-md">
    Simpan Foto
</button>

            <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
                <div class="bg-green-500 p-2 rounded text-white text-center shadow-md animate-bounce">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </form>
    </div>

    <!-- Chat Area -->
    <div class="flex flex-col w-3/4">
        <!-- Chat Box -->
        <div wire:poll.1000ms id="chat-container"
            class="flex-1 overflow-y-auto p-4 bg-[#1e1e2f] flex flex-col-reverse space-y-reverse space-y-4 scrollbar-thin scrollbar-thumb-purple-500 scrollbar-track-[#3b3f73]">
            <!--[if BLOCK]><![endif]--><?php if($obrolan): ?>
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $obrolan->reverse()->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $showAvatar = $index === $obrolan->count() - 1 || $obrolan->values()[$obrolan->count() - $index - 2]->user_id !== $o->user_id;
                    ?>

                    <div class="flex <?php echo e($o->user_id === auth()->id() ? 'justify-end' : 'justify-start'); ?> items-end gap-2 animate-slideIn">
                        <!--[if BLOCK]><![endif]--><?php if($o->user_id !== auth()->id()): ?>
                            <!--[if BLOCK]><![endif]--><?php if($showAvatar): ?>
                                <img src="<?php echo e(asset('storage/avatars/' . ($o->user->foto ?? 'a.png'))); ?>"
                                    class="w-8 h-8 rounded-full ring-2 ring-purple-400 shadow-md">
                            <?php else: ?>
                                <div class="w-8"></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="relative max-w-xs p-3 rounded-2xl shadow transition-all duration-300 <?php echo e($o->user_id === auth()->id() ? 'bg-purple-600 text-white' : 'bg-[#475569]'); ?>">
                            <div>
                                <?php echo e($editPesanId === $o->id ? '' : $o->pesan); ?>

                                <!--[if BLOCK]><![endif]--><?php if($o->file): ?>
                                    <!--[if BLOCK]><![endif]--><?php if(Str::endsWith($o->file, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                        <img src="<?php echo e(asset('storage/' . $o->file)); ?>" class="mt-2 rounded-lg max-w-[200px] border border-white shadow-md hover:scale-105 transition-transform duration-300">
                                    <?php else: ?>
                                        <a href="<?php echo e(asset('storage/' . $o->file)); ?>" target="_blank"
                                            class="block mt-2 text-sm underline">📎 Lihat File</a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Input & Edit Form -->
        <div class="bg-[#252b48] p-4">
            <!--[if BLOCK]><![endif]--><?php if($editPesanId): ?>
                <div class="flex items-center gap-2 bg-yellow-100 p-3 rounded mb-3 text-black animate-fade-in">
                    <input type="text" wire:model.defer="pesanEdit" class="flex-1 p-2 rounded border">
                    <button wire:click="updatePesan" class="bg-purple-600 px-3 py-1 rounded text-white hover:bg-purple-700">Simpan</button>
                    <button wire:click="$set('editPesanId', null)" class="text-gray-600 hover:text-black">Batal</button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <form wire:submit.prevent="kirimpesan" class="flex gap-2 items-end">
                <input type="text" wire:model.defer="pesan" placeholder="Tulis pesan..."
                    class="flex-1 p-2 rounded-md bg-[#374151] text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all duration-200" />

                <input type="file" id="filePesanInput" wire:model="filePesan" class="hidden">
                <label for="filePesanInput"
                    class="inline-flex items-center gap-2 bg-[#4b5563] px-3 py-2 rounded-l-md cursor-pointer hover:bg-[#6b7280] transition-transform duration-200 hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                    <span>Upload</span>
                </label>

                <div wire:loading wire:target="filePesan" class="text-sm text-gray-300">
                    Mengupload file...
                </div>

                <button type="submit"
                    class="bg-purple-600 px-4 py-2 rounded-r-md hover:bg-purple-700 transition duration-150 hover:scale-105 shadow">
                    Kirim
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slideIn {
            animation: slideIn 0.4s ease-out forwards;
        }
    </style>
</div>
<?php /**PATH C:\laragon\www\wheahchelodewi\resources\views/livewire/chat.blade.php ENDPATH**/ ?>