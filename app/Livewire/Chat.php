<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Pribadi;

class Chat extends Component
{
    public $tujuan_id, $tujuan_nama, $pesan;
    public function pilihtujuan($id)
    {
        $tujuan = User::find($id);
        $this->tujuan_id = $tujuan->id;
        $this->tujuan_nama = $tujuan->name;
        $this->pesan = '';
        Pribadi::where('user_id', $this->tujuan_id)
                ->where('tujuan_id', auth()->id())
                ->update(['status' => 1]);
    }
    public function kirimpesan()
    {
        $this->validate([
            'pesan' => 'required'
        ]);

        Pribadi::create([
            'user_id' => auth()->id(),
            'tujuan_id' => $this->tujuan_id,
            'pesan' => $this->pesan,
            'status' => 0
        ]);

        $this->pesan = '';
    }
    public function render()
    {
        $member = User::where('id', '!=', auth()->id())->get();
        $memberunread = [];
        foreach ($member as $m) {
            $belumbaca = Pribadi::where('user_id', $m -> id)
                                    ->where('tujuan_id', auth()->id())
                                    ->where('status', 0)
                                    ->count();
            $memberunread[$m->id]['unread'] = $belumbaca;
            $memberunread[$m->id]['user'] = $m;
        }

        $obrolan = Pribadi::where('user_id', auth()->id())
                            ->where('tujuan_id', $this->tujuan_id)
                            ->orWhere('user_id', $this->tujuan_id)
                            ->where('tujuan_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('livewire.chat')->with([
            'memberunread' => $memberunread,
            'obrolan' => $obrolan ?? null
        ]);
    }
}
