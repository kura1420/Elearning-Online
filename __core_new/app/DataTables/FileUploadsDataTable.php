<?php

namespace App\DataTables;

use App\FileUpload;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FileUploadsDataTable extends DataTable
{

    protected $url = '/sch/file-upload';

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
            ->editColumn('url', function ($query) {
                return "<input type='text' value='{$query->url}' id='url-{$query->id}' readonly /> <button type='button' class='btn btn-sm btn-secondary btnCopyUrl' data-clipboard-action='copy' data-clipboard-target='#url-{$query->id}'><i class='fa fa-copy'></i> Copy URL</button>";
            })
            ->addColumn('action', function ($query) {
                $buttons = array(
                    $this->buttonShow($query->url),
                    // $this->buttonEdit($query->id),
                    $this->buttonDelete($query->id),
                );

                return implode(' ', $buttons);
            })
            ->rawColumns(['url', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\FileUpload $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FileUpload $model)
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
            Column::make('nama'),
            Column::make('tipe'),
            Column::make('url'),
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
        return 'FileUploads_' . date('YmdHis');
    }

    protected function buttonShow($url)
    {
        return "<a href='" . asset($url) . "' target='_blank' class='btn btn-link text-info' data-toggle='tooltip' data-placement='top' title='Lihat'><i class='fa fa-eye'></i></a>";
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
