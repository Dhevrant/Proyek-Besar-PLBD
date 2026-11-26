<?php
class OrderDetail
{
    public static function create(int $idPesanan, array $line): int
    {
        return QueryBuilder::table('detail_pesanan')->insert([
            'id_pesanan'   => $idPesanan,
            'id_menu'      => $line['id_menu'],
            'jumlah'       => $line['jumlah'],
            'harga_satuan' => $line['harga_satuan'],
            'subtotal'     => $line['subtotal'],
        ]);
    }

    public static function byOrder(int $idPesanan): array
    {
        return QueryBuilder::table('detail_pesanan')
            ->select('detail_pesanan.*, menu.nama_menu')
            ->join('menu', 'detail_pesanan.id_menu', '=', 'menu.id_menu')
            ->where('detail_pesanan.id_pesanan', '=', $idPesanan)
            ->orderBy('detail_pesanan.id_detail')->get();
    }
}
