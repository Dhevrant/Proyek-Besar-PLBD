<?php
class User
{
    /** Cari admin berdasarkan email ATAU nomor telepon. */
    public static function findByLogin(string $login): ?array
    {
        return QueryBuilder::table('users')
            ->whereRaw('(email = ? OR telepon = ?)', [$login, $login])
            ->first();
    }

    public static function find(int $id): ?array
    {
        return QueryBuilder::table('users')->where('id_user', '=', $id)->first();
    }
}
