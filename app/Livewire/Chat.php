<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Pribadi;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Chat extends Component
{
    use WithFileUploads;
    public $tujuan_id, $tujuan_nama, $pesan, $is_typing = false, $typingTimer, $penerima_id = null, $fotoProfil, $obrolan, $filePesan, $editPesanId;
    public function pilihtujuan($id)
    {
        $this->penerima_id = $id;
        $tujuan = User::find($id);
        $this->tujuan_id = $tujuan->id;
        $this->tujuan_nama = $tujuan->name;
        $this->pesan = '';
        Pribadi::where('user_id', $this->tujuan_id)
                ->where('tujuan_id', auth()->id())
                ->update(['status' => 1]);
        $this->loadChat();
    }
    public function kirimpesan()
    {
        $filePath = null;
        if ($this->filePesan) {
            $filename = time() . '_' . $this->filePesan->getClientOriginalName();
            $filePath = $this->filePesan->storeAs('public/chat-files', $filename);
        }

        if ($this->pesan && $this->tujuan_id) {
            Pribadi::create([
                'user_id' => auth()->id(),
                'tujuan_id' => $this->tujuan_id,
                'pesan' => $this->pesan,
                'file' => $filePath ? str_replace('public/', '', $filePath) : null,
            ]);
            $this->reset('pesan', 'filePesan');
            $this->loadChat();
        }
    }

    public function render()
    {
        $member = User::where('id', '!=', auth()->id())->get();
        $memberunread = [];
    
        foreach ($member as $m) {
            $belumbaca = Pribadi::where('user_id', $m->id)
                ->where('tujuan_id', auth()->id())
                ->where('status', 0)
                ->count();
            $memberunread[$m->id]['unread'] = $belumbaca;
            $memberunread[$m->id]['user'] = $m;
        }
    
        // Ini biar polling selalu update obrolan terbaru
        if ($this->tujuan_id) {
            $this->loadChat();
        }
    
        return view('livewire.chat')->with([
            'memberunread' => $memberunread,
            'obrolan' => $this->obrolan
        ]);
    }

    public function loadChat()
    {
        $this->obrolan = Pribadi::where(function ($q) {
            $q->where('user_id', auth()->id())->where('tujuan_id', $this->tujuan_id);
        })->orWhere(function ($q) {
            $q->where('user_id', $this->tujuan_id)->where('tujuan_id', auth()->id());
        })->with('user')->orderBy('created_at', 'asc')->get();        
    }

    public function gantiFoto()
    {
        if ($this->fotoProfil) {
            $filename = auth()->id() . '_' . time() . '.' . $this->fotoProfil->getClientOriginalExtension();
            $this->fotoProfil->storeAs('public/avatars', $filename);

            auth()->user()->update(['foto' => $filename]);

            session()->flash('success', 'Foto profil berhasil diubah.');
            $this->reset('fotoProfil'); // reset inputnya
        }
    }

}