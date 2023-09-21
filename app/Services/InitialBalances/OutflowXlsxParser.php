<?php

declare(strict_types=1);

namespace App\Services\InitialBalances;

use App\Services\InitialBalances\Data\OutflowData;
use App\Services\InitialBalances\Data\OutflowDetailsData;
use App\Services\InitialBalances\Exceptions\FileParsingException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Shuchkin\SimpleXLSX;

class OutflowXlsxParser
{
    private array $result = [];
    public function parse(string $fileData): Collection
    {
        $xlsx = SimpleXLSX::parseData($fileData);
        if (!$xlsx) {
            throw new FileParsingException();
        }

        $rows = array_slice($xlsx->rows(), 2);

        foreach ($rows as $row) {
            if ($this->isDate($row[0])) {
                $this->addNewOutflow($row);
            } else {
                $this->addNewOutflowDetails($row);
            }
        }

        return collect($this->result);
    }

    private function isDate(string $date): bool
    {
        try {
            Carbon::createFromFormat('d.m.Y H:i:s', $date);
        } catch (Exception) {
            return false;
        }

        return true;
    }

    private function addNewOutflow(array $row): void
    {
        $this->result[] = OutflowData::from([
            'date' => $row[0],
            'sum' => $row[1],
            'categoryName' => $row[2],
            'details' => []
        ]);
    }

    private function addNewOutflowDetails(array $row): void
    {
        $this->result[count($this->result) - 1]->details[] = OutflowDetailsData::from([
            'nomenclatureName' => $row[0],
            'nomenclatureType' => $row[1] ?: null,
            'count' => $row[2],
            'cost' => $row[3],
            'comment' => $row[4] ?: null,
        ]);
    }
}
