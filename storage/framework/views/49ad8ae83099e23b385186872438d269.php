<div>
    <div class="container mx-auto">
        <div class="flex justify-center md:space-x-4">
            <div class="w-full md:w-1/3">
                <div class="bg-white shadow rounded-lg">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 text-white font-bold px-4 py-2 rounded-t-lg">Members</div>

                    <div class="p-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $memberunread; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button wire:click="pilihtujuan(<?php echo e($member['user']->id); ?>)"
                                class="relative mb-2 w-full px-4 py-2 text-sm font-medium rounded-md <?php echo e($tujuan_id == $member['user']->id ? 'bg-green-500 text-white' : 'bg-blue-200 text-gray-800 hover:bg-green-300'); ?> transition duration-300 ease-in-out">
                                <?php echo e($member['user']->name); ?>

                                <!--[if BLOCK]><![endif]--><?php if($member['unread'] > 0): ?>
                                    <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                        <?php echo e($member['unread']); ?>

                                        <span class="sr-only">unread messages</span>
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/3">
                <div class="bg-white shadow rounded-lg">
                    <div class="bg-gray-100 font-bold px-4 py-2 rounded-t-lg">Obrolan</div>
                    <div class="p-4">
                        <!--[if BLOCK]><![endif]--><?php if($tujuan_id): ?>
                            <div class="h-96 overflow-auto flex flex-col-reverse" wire:poll>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $obrolan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($o->user_id == auth()->id()): ?>
                                        <div class="bg-blue-100 text-blue-800 p-2 rounded-lg mb-2 w-3/4 ml-auto hover:bg-blue-200 transition duration-300 ease-in-out">
                                            <b><?php echo e($o->user->name); ?></b>
                                            <br />
                                            <?php echo e($o->pesan); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="bg-green-100 text-green-800 p-2 rounded-lg mb-2 w-3/4 hover:bg-green-200 transition duration-300 ease-in-out">
                                            <b><?php echo e($o->user->name); ?></b>
                                            <br />
                                            <?php echo e($o->pesan); ?>

                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <br />
                            <div class="flex space-x-2">
                                <input type="text" class="form-input flex-1 border border-gray-300 rounded-md p-2" wire:model="pesan" wire:keydown.enter="kirimpesan">
                                <button wire:click="kirimpesan" class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-2 rounded-md hover:bg-gradient-to-l transition duration-300 ease-in-out">Kirim</button>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\wheahchelodewi\resources\views/livewire/chat.blade.php ENDPATH**/ ?>