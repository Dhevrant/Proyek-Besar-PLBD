<?php
class Order
{
    public const STATUS = [
        'baru' => 'Baru', 'disiapkan' => 'Disiapkan', 'siap' => 'Siap diambil',
        'dikirim' => 'Dikirim', 'selesai' => 'Selesai',
    ];
    public const PENGAMBILAN = ['ambil' => 'Diambil sendiri', 'antar' => 'Diantar'];
    public const PEMBAYARAN  = ['tunai' => 'Tunai', 'qris' => 'QRIS'];

    /** Simpan pesanan + detailnya dalam satu transaksi. $lines: [id_menu,jumlah,harga_satuan,subtotal] */
    public static function createWithDetails(array $header, array $lines): int
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $id = QueryBuilder::table('pesanan')->insert($header);
            foreach ($lines as $line) OrderDetail::create($id, $line);
            $pdo->commit();
            return $id;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function find(int $id): ?array
    {
        return QueryBuilder::table('pesanan')->where('id_pesanan', '=', $id)->first();
    }

    public static function list(string $status = ''): array
    {
        $q = QueryBuilder::table('pesanan')->orderBy('id_pesanan', 'DESC');
        if (isset(self::STATUS[$status])) $q->where('status', '=', $status);
        return $q->limit(100)->get();
    }

    /** Angka untuk 4 kartu ringkasan dashboard. */
    public static function summary(): array
    {
        $c = fn(string $sql) => (int)Database::connection()->query($sql)->fetchColumn();
        return [
            'baru'      => $c("SELECT COUNT(*) FROM pesanan WHERE status='baru'"),
            'disiapkan' => $c("SELECT COUNT(*) FROM pesanan WHERE status='disiapkan'"),
            'siap'      => $c("SELECT COUNT(*) FROM pesanan WHERE status IN ('siap','dikirim')"),
            'selesai'   => $c("SELECT COUNT(*) FROM pesanan WHERE status='selesai' AND DATE(updated_at)=CURDATE()"),
        ];
    }

    public static function updateByAdmin(int $id, array $d): void
    {
        QueryBuilder::table('pesanan')->where('id_pesanan', '=', $id)->update($d);
    }
}
