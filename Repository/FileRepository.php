<?php

namespace File\Repository;

use Core\Database\DB;
use Core\Database\Repository;

class FileRepository extends \Core\Repository
{

    public function defaultTable(): string
    {
        return 'file';
    }

    public function getByIdString(string $id)
    {
        return DB::get("SELECT * FROM file WHERE id = ?", [$id])[0] ?? null;
    }
}