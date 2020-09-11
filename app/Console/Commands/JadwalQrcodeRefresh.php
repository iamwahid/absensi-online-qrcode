<?php

namespace App\Console\Commands;

use App\Repositories\Backend\JadwalRepository;
use Illuminate\Console\Command;

class JadwalQrcodeRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jadwal:qrcode-refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Jadwal QRcode Regenerate';
    protected $jadwals;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JadwalRepository $jadwals)
    {
        parent::__construct();
        $this->jadwals = $jadwals;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->jadwals->get() as $jadwal) {
            $jadwal->generateKode();
            $this->info($jadwal->strigable.' Regenerated'); 
        }
        $this->info('All Generated');
    }
}
