<?php
class Menu
{
    public const KATEGORI = ['Lauk', 'Sayur', 'Minuman', 'Paket'];
    public const STATUS   = ['tersedia' => 'Tersedia', 'habis' => 'Habis'];

    private static function filtered(string $search, string $kategori): QueryBuilder
    {
        $q = QueryBuilder::table('menu');
        if ($search !== '') {
            $like = '%' . $search . '%';
            $q->whereRaw('(nama_menu LIKE ? OR deskripsi LIKE ?)', [$like, $like]);
        }
        if (in_array($kategori, self::KATEGORI, true)) {
            $q->where('kategori', '=', $kategori);
        }
        return $q;
    }

    /** @return array{items:array,total:int,pages:int,page:int} */
    public static function paginate(string $search, string $kategori, int $page, int $perPage = 8): array
    {
        $total = self::filtered($search, $kategori)->count();
        $pages = max(1, (int)ceil($total / $perPage));
        $page  = min(max(1, $page), $pages);
        $items = self::filtered($search, $kategori)
            ->orderBy('id_menu', 'DESC')
            ->limit($perPage)->offset(($page - 1) * $perPage)->get();
        return compact('items', 'total', 'pages', 'page');
    }

    public static function all(): array
    {
        return QueryBuilder::table('menu')->orderBy('id_menu', 'DESC')->get();
    }

    public static function available(): array
    {
        return QueryBuilder::table('menu')->where('status', '=', 'tersedia')->orderBy('kategori')->orderBy('nama_menu')->get();
    }

    public static function featured(int $n = 4): array
    {
        return QueryBuilder::table('menu')->where('status', '=', 'tersedia')->orderBy('id_menu', 'DESC')->limit($n)->get();
    }

    public static function find(int $id): ?array
    {
        return QueryBuilder::table('menu')->where('id_menu', '=', $id)->first();
    }

    /** Ambil beberapa menu sekaligus, hasil di-index dengan id_menu. */
    public static function findMany(array $ids): array
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));
        if (!$ids) return [];
        $rows = QueryBuilder::table('menu')
            ->whereRaw('id_menu IN (' . implode(',', array_fill(0, count($ids), '?')) . ')', $ids)->get();
        return array_column($rows, null, 'id_menu');
    }

    public static function create(array $d): int { return QueryBuilder::table('menu')->insert($d); }

    public static function update(int $id, array $d): void
    {
        QueryBuilder::table('menu')->where('id_menu', '=', $id)->update($d);
    }

    public static function delete(int $id): void
    {
        QueryBuilder::table('menu')->where('id_menu', '=', $id)->delete();
    }
}
