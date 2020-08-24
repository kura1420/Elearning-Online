<?php

namespace App\DataTables;

use App\Guru;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class GurusDataTable extends DataTable
{

    protected $url = '/sch/guru';

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
            ->addColumn('action', function ($query) {
                $buttons = array(
                    // $this->buttonShow($query->id),
                    $this->buttonEdit($query->id),
                    $this->buttonDelete($query->id),
                );

                return implode($buttons, ' ');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Guru $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Guru $model)
    {
        return $model->newQuery()
                    ->where('sekolah_id', session('sch_id'));
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
                        Button::make([
                            'text' => '<i class="fa fa-edit"></i>Import',
                            'className' => '',
                            'action' => 'function(e, dt, node, config) { window.location.href = "'. url($this->url . '/import') .'"; }'
                        ]),
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
            Column::make('nomor_induk'),
            Column::make('nama'),
            Column::make('email'),
            Column::make('handphone'),
            Column::make('jabatan'),
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
        return 'Gurus_' . date('YmdHis');
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
