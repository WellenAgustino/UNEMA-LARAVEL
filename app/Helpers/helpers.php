<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        if ($angka === null || $angka === '' || !is_numeric($angka)) {
            return "Rp 0";
        }
        
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($date, $format = 'd F Y')
    {
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        
        $timestamp = strtotime($date);
        $day = date('d', $timestamp);
        $month = $bulan[date('n', $timestamp)];
        $year = date('Y', $timestamp);
        $dayName = $hari[date('l', $timestamp)];
        
        if ($format == 'd F Y') {
            return $day . ' ' . $month . ' ' . $year;
        } elseif ($format == 'l, d F Y') {
            return $dayName . ', ' . $day . ' ' . $month . ' ' . $year;
        } else {
            return date($format, $timestamp);
        }
    }
}