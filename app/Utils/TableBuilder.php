<?php

namespace App\Utils;

use Illuminate\Support\Facades\View;
use App\Http\Resources\PaginateResource;

// TODO: Find better way to do controls like edit, delete...

class TableBuilder
{
    protected array $columns = [];

    protected bool $pagination = true;

    public function __construct(
        public string $name
    ) {
        $this->name = $name.'Table';
    }

    public function addColumn(
        string $header,
        string $field,
        ?string $type = 'field',
    ): self {
        $this->columns[] = [
            'header' => $header,
            'type' => $type,
            'field' => $field,
        ];

        return $this;
    }

    public function addRowIndex(): self
    {
        return $this->addColumn(
            header: '#',
            type: 'index',
            field: '',
        );
    }

    public function addControl(
        string $type,
        string $field
    ): self {
        return $this->addColumn(
            header: '',
            type: 'control',
            field: $field,
        );
    }

    public function setPagination(bool $show = true): void
    {
        $this->pagination = $show;
    }

    public function setData(PaginateResource $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function render(): string
    {
        return View::make('table', [
            'name' => $this->name,
            'columns' => $this->columns,
            'data' => $this->data,
            'pagination' => $this->pagination,
        ])->render();
    }

    public static function build(
        string $name,
        array $columns,
        PaginateResource $data,
        bool $withRowIndex = true,
        bool $pagination = true
    ): string {
        // TODO: Implement caching
        // NOTE: Try making property for, and than pass form

        $tableBuilder = new self(name: $name);

        if ($withRowIndex) {
            $tableBuilder->addRowIndex();
        }

        foreach ($columns as $column) {
            $tableBuilder->addColumn(
                header: $column['header'],
                field: $column['field'],
                type: $column['type'] ?? 'field'
            );
        }

        $tableBuilder
            ->setData($data)
            ->setPagination($pagination);

        return $tableBuilder->render();
    }
}
