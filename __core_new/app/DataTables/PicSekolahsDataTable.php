<?php

namespace App\DataTables;

use App\PicSekolah;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PicSekolahsDataTable extends DataTable
{

    protected $url = '/mgt/pic-sekolah';

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
                        ->where('pic_sekolahs.nama', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('pic_sekolahs.email', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('pic_sekolahs.handphone', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('pic_sekolahs.telp', 'like', '%' . request('search')['value'] . '%')
                        ->orWhere('sekolahs.nama', 'like', '%' . request('search')['value'] . '%');
                }
            })
            ->addColumn('action', function ($query) {
                $buttons = array(
                    // $this->buttonShow($query->id),
                    $this->buttonEdit($query->id),
                    $this->buttonDelete($query->id),
                );

                return implode(' ', $buttons);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\PicSekolah $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PicSekolah $model)
    {
        return $model->newQuery()
                ->join('sekolahs', 'pic_sekolahs.sekolah_id', '=', 'sekolahs.id')
                ->select([
                    'pic_sekolahs.id',
                    'pic_sekolahs.nama',
                    'pic_sekolahs.email',
                    'pic_sekolahs.handphone',
                    'pic_sekolahs.telp',
                    'sekolahs.nama as sekolah',
                ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('picsekolahs-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('excel'),
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
            Column::make('sekolah'),
            Column::make('nama'),
            Column::make('email'),
            Column::make('handphone'),
            Column::make('telp'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-right'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PicSekolahs_' . date('YmdHis');
    }

    protected function buttonShow($id)
    {
        return "<a href='" . url($this->url . '/' . $id) . "' class='btn btn-link btn-info' data-toggle='tooltip' data-placement='top' title='Lihat'><i class='fa fa-eye'></i></a>";
    }

    protected function buttonEdit($id)
    {
        return "<a href='" . url($this->url . '/' . $id . '/edit') . "' class='btn btn-link btn-warning' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i></a>";
    }

    protected function buttonDelete($id)
    {
        return "<button type='button' class='btn btn-link btn-danger btnRemove' value='" . $id . "' data-toggle='tooltip' data-placement='top' title='Hapus'><i class='fa fa-trash'></i></button>";
    }
}
