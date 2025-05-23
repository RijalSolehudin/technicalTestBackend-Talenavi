<?php

namespace App\Exports;

use App\Models\Todo;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TodoExport implements FromQuery, WithHeadings, WithEvents, WithCustomStartCell, ShouldAutoSize
{
   
    

   public function query()
    {
    $query = Todo::query();

    $query->select('id','title','assignee','due_date','time_tracked','status','priority');

    if (request('title')) {
        $query->where('title', 'like', '%' . request('title') . '%');
    }

    if ($assignees = request('assignee')) {
        $query->whereIn('assignee', explode(',', $assignees));
    }

    if (request('start') && request('end')) {
        $query->whereBetween('due_date', [request('start'), request('end')]);
    }

    if (request('min') && request('max')) {
        $query->whereBetween('time_tracked', [request('min'), request('max')]);
    }

    if ($status = request('status')) {
        $query->whereIn('status', explode(',', $status));
    }

    if ($priority = request('priority')) {
        $query->whereIn('priority', explode(',', $priority));
    }

    return $query;
    }
    public function headings(): array
    {
        return ['ID', 'Title', 'Assignee', 'Due Date', 'Time Tracked', 'Status', 'Priority'];
    }

    public function startCell():string {
        return 'A1';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $totalTodos = $this->query()->count();
                $totalTime = $this->query()->sum('time_tracked');

                $row = $totalTodos + 4;

                $event->sheet->setCellValue('C' . $row, "Total Tugas");
                $event->sheet->setCellValue('D' . $row, $totalTodos);
                $event->sheet->setCellValue('F' . $row, 'Total Time Tracked');
                $event->sheet->setCellValue('G' . $row, $totalTime);
            
            
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFEFEFEF',
                    ],
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF888888'],
                    ],
                ],
            ];

            $event->sheet->getStyle("C{$row}:G{$row}")->applyFromArray($styleArray);
            },
        ];
    }

}
