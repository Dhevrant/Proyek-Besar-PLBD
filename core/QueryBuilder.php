<?php
/**
 * Query Builder sederhana berbasis PDO prepared statement.
 * Contoh: QueryBuilder::table('menu')->where('status','=','tersedia')->orderBy('id_menu','DESC')->limit(4)->get();
 */
class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private string $columns = '*';
    private array $joins = [];
    private array $wheres = [];
    private array $bindings = [];
    private array $orders = [];
    private ?int $limit = null;
    private ?int $offset = null;

    private function __construct(string $table)
    {
        $this->table = self::ident($table);
        $this->pdo = Database::connection();
    }

    public static function table(string $table): self
    {
        return new self($table);
    }

    /** Validasi nama tabel/kolom (hanya huruf, angka, _ dan .) */
    private static function ident(string $name): string
    {
        if (!preg_match('/^[A-Za-z0-9_.]+$/', $name)) {
            throw new InvalidArgumentException("Identifier tidak valid: $name");
        }
        return $name;
    }

    /** $columns ditulis oleh programmer (bukan input user). */
    public function select(string $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function join(string $table, string $left, string $op, string $right, string $type = 'INNER'): self
    {
        $type = strtoupper($type) === 'LEFT' ? 'LEFT' : 'INNER';
        $this->joins[] = "$type JOIN " . self::ident($table) . ' ON ' . self::ident($left) . " $op " . self::ident($right);
        return $this;
    }

    public function where(string $column, string $op, $value): self
    {
        $allowed = ['=', '!=', '<>', '<', '>', '<=', '>=', 'LIKE'];
        if (!in_array(strtoupper($op), $allowed, true)) {
            throw new InvalidArgumentException('Operator tidak diizinkan');
        }
        $this->wheres[] = self::ident($column) . " $op ?";
        $this->bindings[] = $value;
        return $this;
    }

    /** Kondisi mentah dengan placeholder ?, mis. whereRaw('(a LIKE ? OR b LIKE ?)', [$x, $x]) */
    public function whereRaw(string $sql, array $params = []): self
    {
        $this->wheres[] = $sql;
        array_push($this->bindings, ...$params);
        return $this;
    }

    public function orderBy(string $column, string $dir = 'ASC'): self
    {
        $this->orders[] = self::ident($column) . ' ' . (strtoupper($dir) === 'DESC' ? 'DESC' : 'ASC');
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    private function whereSql(): string
    {
        return $this->wheres ? ' WHERE ' . implode(' AND ', $this->wheres) : '';
    }

    private function run(string $sql, array $params): PDOStatement
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function get(): array
    {
        $sql = "SELECT {$this->columns} FROM {$this->table}";
        if ($this->joins)  $sql .= ' ' . implode(' ', $this->joins);
        $sql .= $this->whereSql();
        if ($this->orders) $sql .= ' ORDER BY ' . implode(', ', $this->orders);
        if ($this->limit !== null)  $sql .= ' LIMIT ' . (int)$this->limit;
        if ($this->offset !== null) $sql .= ' OFFSET ' . (int)$this->offset;
        return $this->run($sql, $this->bindings)->fetchAll();
    }

    public function first(): ?array
    {
        $this->limit = 1;
        $rows = $this->get();
        return $rows[0] ?? null;
    }

    public function count(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";
        if ($this->joins) $sql .= ' ' . implode(' ', $this->joins);
        $sql .= $this->whereSql();
        return (int)$this->run($sql, $this->bindings)->fetch()['total'];
    }

    /** Mengembalikan id baris yang baru dibuat. */
    public function insert(array $data): int
    {
        $cols = array_map([self::class, 'ident'], array_keys($data));
        $sql = "INSERT INTO {$this->table} (" . implode(', ', $cols) . ') VALUES (' . implode(', ', array_fill(0, count($cols), '?')) . ')';
        $this->run($sql, array_values($data));
        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data): int
    {
        if (!$this->wheres) throw new LogicException('UPDATE tanpa WHERE tidak diizinkan');
        $set = implode(', ', array_map(fn($c) => self::ident($c) . ' = ?', array_keys($data)));
        $sql = "UPDATE {$this->table} SET $set" . $this->whereSql();
        return $this->run($sql, [...array_values($data), ...$this->bindings])->rowCount();
    }

    public function delete(): int
    {
        if (!$this->wheres) throw new LogicException('DELETE tanpa WHERE tidak diizinkan');
        return $this->run("DELETE FROM {$this->table}" . $this->whereSql(), $this->bindings)->rowCount();
    }
}
