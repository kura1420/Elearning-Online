<?php

namespace App\DataTables;

use App\Soal;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SoalsDataTable extends DataTable
{   

    protected $url = '/sch/soal';

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                if (request('search')['value']) {
                    $query
                        ->where('soals.judul', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('soals.tipe', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('tahun_ajarans.merge_periode', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('tahun_ajarans.semester', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('kelas.nama', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('pelajarans.nama', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('pelajaran_tipes.nama', 'like', '%' . request('search')['value'] . '%');
                }
            })
            ->editColumn('tipe', function ($query) {
                $tipe = NULL;
                switch ($query->tipe) {
                    case 'pg':
                        $tipe = 'Pilihan Ganda';
                        break;

                    case 'es':
                        $tipe = 'Essay';
                        break;

                    case 'cu':
                        $tipe = 'Custom';
                        break;
                    
                    default:
                        $tipe = 'No Defined';
                        break;
                }

                return $tipe;
            })
            ->addColumn('action', function ($query) {
                $buttons = array(
                    $this->buttonCopy($query->id),
                    $this->buttonShow($query->id),
                    $this->buttonEdit($query->id),
                    $this->buttonDelete($query->id),
                );

                return implode(' ', $buttons);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Soal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Soal $model)
    {
        if (auth()->user()->level == 'gr') {
            $pelajaranId = \App\GuruPelajaran::whereGuruId(session()->get('sch_pic'))
                                ->whereAktif(1)
                                ->select('pelajaran_id')
                                ->get()
                                ->toArray();

            return $model->newQuery()
                    ->join('tahun_ajarans', 'soals.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                    ->join('kelas', 'soals.kelas_id', '=', 'kelas.id')
                    ->join('pelajarans', 'soals.pelajaran_id', '=', 'pelajarans.id')
                    ->join('pelajaran_tipes', 'soals.pelajaran_tipe_id', '=', 'pelajaran_tipes.id')
                    ->where('soals.sekolah_id', session('sch_id'))
                    ->whereIn('soals.pelajaran_id', $pelajaranId)
                    ->select([
                        'soals.id',
                        'soals.judul',
                        'soals.tipe',
                        DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) AS tahun_ajaran'),
                        'kelas.nama as kelas',
                        'pelajarans.nama as pelajaran',
                        'pelajaran_tipes.nama as pelajaran_tipe',
                    ]);
        } else {
            return $model->newQuery()
                    ->join('tahun_ajarans', 'soals.tahun_ajaran_id', '=', 'tahun_ajarans.id')
                    ->join('kelas', 'soals.kelas_id', '=', 'kelas.id')
                    ->join('pelajarans', 'soals.pelajaran_id', '=', 'pelajarans.id')
                    ->join('pelajaran_tipes', 'soals.pelajaran_tipe_id', '=', 'pelajaran_tipes.id')
                    ->where('soals.sekolah_id', session('sch_id'))
                    ->select([
                        'soals.id',
                        'soals.judul',
                        'soals.tipe',
                        DB::raw('CONCAT(tahun_ajarans.merge_periode, "/", tahun_ajarans.semester) AS tahun_ajaran'),
                        'kelas.nama as kelas',
                        'pelajarans.nama as pelajaran',
                        'pelajaran_tipes.nama as pelajaran_tipe',
                    ]);
        }
        

        
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('datatables')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        // Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('tahun_ajaran'),
            Column::make('kelas'),
            Column::make('pelajaran'),
            Column::make('pelajaran_tipe'),
            Column::make('judul'),
            Column::make('tipe'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(150)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Soals_' . date('YmdHis');
    }

    protected function buttonCopy($id)
    {
        return "<a href='" . url($this->url . '/' . $id . '/copy') . "' class='btn btn-link text-secondary' data-toggle='tooltip' data-placement='top' title='Copy'><i class='fa fa-copy'></i></a>";
    }

    protected function buttonShow($id)
    {
        return "<a href='" . url($this->url . '/' . $id) . "' class='btn btn-link text-info' data-toggle='tooltip' data-placement='top' title='Lihat'><i class='fa fa-eye'></i></a>";
    }

    protected function buttonEdit($id)
    {
        return "<a href='" . url($this->url . '/' . $id . '/edit') . "' class='btn btn-link text-warning' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i></a>";
    }

    protected function buttonDelete($id)
    {
        return "<button type='button' class='btn btn-link text-danger btnRemove' value='" . $id . "' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='fa fa-trash'></i></button>";
    }
}
