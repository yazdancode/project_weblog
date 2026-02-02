<?php

namespace System\Database\Traits;

trait HasSoftDelete
{
    protected string $sql = '';
    protected $collection = [];
    protected $primaryKey = 'id';
    protected $deletedAt = 'deleted_at';
    protected function deleteMethod($id = null)
    {
        $object = $this;
        if ($id) {
            $this->resetQuery();
            $object = $this->findMethod($id);
        }

        if ($object) {
            $object->resetQuery();
            $object->setSql("UPDATE " . $object->getTableName() . " SET " . $this->getAttributeName($this->deletedAt) . " = NOW() ");
            $object->setWhere("AND", $this->getAttributeName($object->primaryKey) . " = ?");
            $object->addValue($object->primaryKey, $object->{$object->primaryKey});
            return $object->executeQuery();
        }

        return false;
    }
    protected function allMethod()
    {
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();

        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }

        return [];
    }
    protected function findMethod($id)
    {
        $this->resetQuery();
        $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        $this->setWhere("AND", $this->getAttributeName($this->primaryKey) . " = ?");
        $this->addValue($this->primaryKey, $id);
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");

        $statement = $this->executeQuery();
        $data = $statement->fetch();

        $this->setAllowedMethods(['update', 'delete', 'save']);

        if ($data) {
            return $this->arrayToAttributes($data);
        }

        return null;
    }
    protected function getMethod($fields = [])
    {
        if ($this->sql == '') {
            if (empty($fields)) {
                $fieldsStr = $this->getTableName() . '.*';
            } else {
                foreach ($fields as $key => $field) {
                    $fields[$key] = $this->getAttributeName($field);
                }
                $fieldsStr = implode(' , ', $fields);
            }

            $this->setSql("SELECT $fieldsStr FROM " . $this->getTableName());
        }

        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
        $statement = $this->executeQuery();
        $data = $statement->fetchAll();

        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }

        return [];
    }
    protected function paginateMethod($perPage)
    {
        $this->setWhere("AND", $this->getAttributeName($this->deletedAt) . " IS NULL ");
        $totalRows = $this->getCount();

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $totalPages = ceil($totalRows / $perPage);

        $currentPage = max(min($currentPage, $totalPages), 1);
        $currentRow = ($currentPage - 1) * $perPage;

        $this->setLimit($currentRow, $perPage);

        if ($this->sql == '') {
            $this->setSql("SELECT " . $this->getTableName() . ".* FROM " . $this->getTableName());
        }

        $statement = $this->executeQuery();
        $data = $statement->fetchAll();

        if ($data) {
            $this->arrayToObjects($data);
            return $this->collection;
        }

        return [];
    }
}