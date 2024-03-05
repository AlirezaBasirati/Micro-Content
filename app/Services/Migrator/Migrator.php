<?php

namespace App\Services\Migrator;

use Illuminate\Console\Command;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class Migrator extends Command
{
    protected int $chunkSize = 100;

    protected int $total = 0;

    protected int $count = 0;

    protected int $last = 1;

    protected int $current = 1;

    public function handle()
    {
        $this->boot();
        $this->chunkSize = $this->option('chunk');
        $this->warn('reset destination migrated ...');
        $this->reset();

        $this->info("items will be transferred ...");
        $bar = $this->output->createProgressBar();
        $start = now();
        do {
            $data = $this->getData($this->current);
            if($this->current == 1) {
                $this->total = $data->total();
                $this->info("total items: " . $this->total);
                $this->last = $data->lastPage();
                $bar->start();
            }
            $bar->setMaxSteps($this->last);
            $this->bulkInsert($data->items());
            $bar->advance();
        }
        while (++$this->current <= $this->last);
        $end = now();
        $this->count = $this->count();
        $this->finish();
        $bar->finish();
        $time = $end->diffInSeconds($start);
        $this->info("\nduration synced : " . floor($time / 3600) . gmdate(":i:s", $time));

        if($this->total == $this->count) {
            $this->info('complete synced');
        }
        else {
            $this->error("incomplete synced because source $this->total items but $this->count items migrated.");
        }
        $this->report();
    }

    abstract public function getData(int $page): LengthAwarePaginator;

    abstract public function reset();

    abstract public function bulkInsert(array $data);

    abstract public function mapper(array $item): ?array;

    abstract public function count(): int;

    public function boot()
    {
        //
    }

    public function finish()
    {
        //
    }

    public function report()
    {
        //
    }
}
