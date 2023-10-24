<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Helper
{
  public const ALL = 'Semua Data';
  public const DEFAULT_PASSWORD = 'password';
  public const NEW_PASSWORD = 'password@baru123';

  /**
   * Check permission to action datatables;
   *
   * @param  mixed $permissions
   * @return void
   */
  public static function checkPermissions(array $permissions = []): bool
  {
    if (Auth::user()->canAny($permissions)) :
      return true;
    endif;

    return false;
  }

  /**
   * Helper to Upload Files.
   *
   * @return void
   */
  public static function uploadFile(
    Request $request,
    string $filePath,
    string $currentFilePath = null
  ) {
    if ($request->file('file')) {
      if ($currentFilePath) {
        Storage::delete($currentFilePath);
      }
      return Storage::putFile("public/{$filePath}", $request->file('file'));
    } elseif ($currentFilePath) {
      return $currentFilePath;
    } else {
      return null;
    }
  }

  public static function redirectAfterUpdateUser(User $user)
  {
    if (me()->id != $user->id) :
      return redirect(route('users.index'))->with('success', trans('session.update'));
    else :
      return redirect(route('users.show', me()->uuid))->with('success', trans('Berhasil Memperbaharui Profil Anda'));
    endif;
  }

  /**
   * Change format date to indonesian date.
   *
   * @param  mixed $date
   * @param  mixed $showDay
   * @return void
   */
  public static function parseDateTime($date, bool $showDay = true)
  {
    $date_name  = array(
      'Minggu',
      'Senin',
      'Selasa',
      'Rabu',
      'Kamis',
      'Jum\'at',
      'Sabtu'
    );

    $month_name = array(
      1 =>
      'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    );

    $tahun = substr($date, 0, 4);
    $bulan = $month_name[(int) substr($date, 5, 2)];
    $tanggal = substr($date, 8, 2);
    $text = '';

    if ($showDay) {
      $urutan_hari = date('w', mktime(0, 0, 0, substr($date, 5, 2), $tanggal, $tahun));
      $hari = $date_name[$urutan_hari];
      $text .= "$hari, $tanggal $bulan $tahun";
    } else {
      $text .= "$tanggal $bulan $tahun";
    }

    return $text;
  }
}
