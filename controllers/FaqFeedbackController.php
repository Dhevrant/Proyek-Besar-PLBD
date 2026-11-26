<?php
class FaqFeedbackController
{
    /* ===================== PUBLIK ===================== */

    public function index(): void
    {
        render('home/faq', ['title' => 'FAQ', 'active' => 'faq', 'faqs' => FaqFeedback::faqs()]);
    }

    public function kirim(): void
    {
        csrf_verify();
        // honeypot anti-spam: kolom "website" disembunyikan, bot biasanya mengisinya
        if (!empty($_POST['website'])) redirect('faq');

        if (time() - ($_SESSION['last_feedback'] ?? 0) < 30) {
            flash('error', 'Mohon tunggu sebentar sebelum mengirim masukan lagi.');
            redirect('faq');
        }

        $nama = trim((string)($_POST['nama'] ?? ''));
        $isi  = trim((string)($_POST['isi'] ?? ''));
        if ($isi === '' || mb_strlen($isi) < 5 || mb_strlen($isi) > 1000) {
            set_old($_POST);
            flash('error', 'Kritik/saran wajib diisi (5–1000 karakter).');
            redirect('faq');
        }
        if (mb_strlen($nama) > 100) $nama = mb_substr($nama, 0, 100);

        FaqFeedback::createFeedback($nama !== '' ? $nama : null, $isi);
        $_SESSION['last_feedback'] = time();
        flash('success', 'Terima kasih, kritik dan saran Anda sudah kami terima.');
        redirect('faq');
    }

    /* ===================== ADMIN ===================== */

    public function adminIndex(): void
    {
        $edit = isset($_GET['edit']) ? FaqFeedback::findFaq((int)$_GET['edit']) : null;
        render('admin/faq', [
            'title' => 'FAQ & Kritik Saran', 'faqs' => FaqFeedback::faqs(),
            'feedbacks' => FaqFeedback::feedbacks(), 'edit' => $edit,
        ], 'admin/layout');
    }

    public function faqSave(): void
    {
        csrf_verify();
        $id = (int)($_POST['id_faq_feedback'] ?? 0);
        $q  = trim((string)($_POST['pertanyaan'] ?? ''));
        $a  = trim((string)($_POST['jawaban'] ?? ''));

        if ($q === '' || $a === '' || mb_strlen($q) > 255) {
            set_old($_POST);
            flash('error', 'Pertanyaan dan jawaban wajib diisi.');
            redirect('admin/faq', $id ? ['edit' => $id] : []);
        }

        if ($id && FaqFeedback::findFaq($id)) {
            FaqFeedback::updateFaq($id, $q, $a);
            flash('success', 'FAQ diperbarui.');
        } else {
            FaqFeedback::createFaq($_SESSION['admin']['id'], $q, $a);
            flash('success', 'FAQ ditambahkan.');
        }
        redirect('admin/faq');
    }

    public function faqDelete(): void
    {
        csrf_verify();
        FaqFeedback::delete((int)($_POST['id'] ?? 0), 'faq');
        flash('success', 'FAQ dihapus.');
        redirect('admin/faq');
    }

    public function feedbackDelete(): void
    {
        csrf_verify();
        FaqFeedback::delete((int)($_POST['id'] ?? 0), 'kritik');
        flash('success', 'Masukan dihapus.');
        redirect('admin/faq');
    }
}
