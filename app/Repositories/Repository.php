<?php

namespace App\Repositories;

/**
 */
interface Repository
{
    public function store(array $data);

    public function show($id);

    public function update(array $data, $id);

    public function destroy($id);

    public function all();
}
