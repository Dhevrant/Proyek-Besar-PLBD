<?php
class FaqFeedback
{
    public static function faqs(?int $limit = null): array
    {
        $q = QueryBuilder::table('faq_feedback')->where('tipe', '=', 'faq')->orderBy('id_faq_feedback');
        if ($limit) $q->limit($limit);
        return $q->get();
    }

    public static function feedbacks(): array
    {
        return QueryBuilder::table('faq_feedback')->where('tipe', '=', 'kritik')->orderBy('id_faq_feedback', 'DESC')->get();
    }

    public static function findFaq(int $id): ?array
    {
        return QueryBuilder::table('faq_feedback')->where('id_faq_feedback', '=', $id)->where('tipe', '=', 'faq')->first();
    }

    public static function createFaq(int $idUser, string $q, string $a): int
    {
        return QueryBuilder::table('faq_feedback')->insert(['id_user' => $idUser, 'tipe' => 'faq', 'judul' => $q, 'isi' => $a]);
    }

    public static function updateFaq(int $id, string $q, string $a): void
    {
        QueryBuilder::table('faq_feedback')->where('id_faq_feedback', '=', $id)->where('tipe', '=', 'faq')
            ->update(['judul' => $q, 'isi' => $a]);
    }

    public static function createFeedback(?string $nama, string $isi): int
    {
        return QueryBuilder::table('faq_feedback')->insert(['tipe' => 'kritik', 'nama_pengirim' => $nama, 'isi' => $isi]);
    }

    public static function delete(int $id, string $tipe): void
    {
        QueryBuilder::table('faq_feedback')->where('id_faq_feedback', '=', $id)->where('tipe', '=', $tipe)->delete();
    }
}
