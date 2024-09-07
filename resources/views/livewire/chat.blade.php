<div>
    <div class="container mx-auto">
        <div class="flex justify-center md:space-x-4">
            <div class="w-full md:w-1/3">
                <div class="bg-white shadow rounded-lg">
                    <div class="bg-gradient-to-r from-blue-500 to-green-500 text-white font-bold px-4 py-2 rounded-t-lg">Members</div>

                    <div class="p-4">
                        @foreach ($memberunread as $member)
                            <button wire:click="pilihtujuan({{ $member['user']->id }})"
                                class="relative mb-2 w-full px-4 py-2 text-sm font-medium rounded-md {{ $tujuan_id == $member['user']->id ? 'bg-green-500 text-white' : 'bg-blue-200 text-gray-800 hover:bg-green-300' }} transition duration-300 ease-in-out">
                                {{ $member['user']->name }}
                                @if ($member['unread'] > 0)
                                    <span class="absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs rounded-full px-2 py-1">
                                        {{ $member['unread'] }}
                                        <span class="sr-only">unread messages</span>
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/3">
                <div class="bg-white shadow rounded-lg">
                    <div class="bg-gray-100 font-bold px-4 py-2 rounded-t-lg">Obrolan</div>
                    <div class="p-4">
                        @if ($tujuan_id)
                            <div class="h-96 overflow-auto flex flex-col-reverse" wire:poll>
                                @foreach ($obrolan as $o)
                                    @if ($o->user_id == auth()->id())
                                        <div class="bg-blue-100 text-blue-800 p-2 rounded-lg mb-2 w-3/4 ml-auto hover:bg-blue-200 transition duration-300 ease-in-out">
                                            <b>{{ $o->user->name }}</b>
                                            <br />
                                            {{ $o->pesan }}
                                        </div>
                                    @else
                                        <div class="bg-green-100 text-green-800 p-2 rounded-lg mb-2 w-3/4 hover:bg-green-200 transition duration-300 ease-in-out">
                                            <b>{{ $o->user->name }}</b>
                                            <br />
                                            {{ $o->pesan }}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <br />
                            <div class="flex space-x-2">
                                <input type="text" class="form-input flex-1 border border-gray-300 rounded-md p-2" wire:model="pesan" wire:keydown.enter="kirimpesan">
                                <button wire:click="kirimpesan" class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-2 rounded-md hover:bg-gradient-to-l transition duration-300 ease-in-out">Kirim</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>