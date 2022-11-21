<?php
defined('BASEPATH') or exit('No direct script access allowed');

$username = 'adminfdv';
$password = 'digitalmind12345';
$auth = 'Basic ' . base64_encode($username . ':' . $password);

define('AUTH_API', $auth);

// api local
define('URL_API', 'http://localhost/koperasi-cu/cu-api/v1/');

// api kosayu
//define('URL_API', 'http://kosayuapi.ninjasquad.online/v1/');

// api ss
//define('URL_API', 'http://api.ninjasquad.online/v1/');

// api tm
//define('URL_API', 'http://tyasapi.ninjasquad.online/v1/');

// config kosayu
define('CONFIG_SITE', array(
    'logo_dashboard' => array(
        'filename' => 'kosayu.png',
        'width' => '150px'
    ),
    'site_title_dashboard' => '',
    'logo_login' => 'Lambang_Kabupaten_Sleman.png',
    'style_logo_login' => 'style="margin: 50px"',
    'meta_head' => '
        <link rel="icon" href="themes/backend/gentelella/images/Lambang_Kabupaten_Sleman.png" sizes="32x32" />
        <link rel="icon" href="themes/backend/gentelella/images/Lambang_Kabupaten_Sleman.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="themes/backend/gentelella/images/Lambang_Kabupaten_Sleman.png" />
        <meta name="msapplication-TileImage" content="themes/backend/gentelella/images/Lambang_Kabupaten_Sleman.png" />
    '
));

// config SS
//define('CONFIG_SITE', array(
//    'logo_dashboard' => array(
//        'filename' => 'kosayu.png',
//        'width' => '150px'
//    ),
//    'site_title_dashboard' => '',
//    'logo_login' => 'logo-kopdit-kosayu.png',
//    'style_logo_login' => 'style="margin: 50px"',
//    'meta_head' => '
//        <link rel="icon" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-32x32.png" sizes="32x32" />
//        <link rel="icon" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-192x192.png" sizes="192x192" />
//        <link rel="apple-touch-icon-precomposed" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-180x180.png" />
//        <meta name="msapplication-TileImage" content="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-270x270.png" />
//    '
//));

// config TM
//define('CONFIG_SITE', array(
//    'logo_dashboard' => array(
//        'filename' => 'kosayu.png',
//        'width' => '150px'
//    ),
//    'site_title_dashboard' => '',
//    'logo_login' => 'logo-kopdit-kosayu.png',
//    'style_logo_login' => 'style="margin: 50px"',
//    'meta_head' => '
//        <link rel="icon" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-32x32.png" sizes="32x32" />
//        <link rel="icon" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-192x192.png" sizes="192x192" />
//        <link rel="apple-touch-icon-precomposed" href="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-180x180.png" />
//        <meta name="msapplication-TileImage" content="http://kopditkosayu.co.id/kk/wp-content/uploads/2017/03/cropped-logo-kopdit-kosayu2-270x270.png" />
//    '
//));


define('MEMBER_STATUS', array('<span class="label label-success">Anggota Koperasi</span>', '<span class="label label-primary">ALB Anak</span>', '<span class="label label-info">ALB WNA</span>', '<span class="label label-default">ALB Luar Negeri</span>', '<span class="label label-warning">ALB Khusus</span>', '<span class="label label-danger">Calon Anggota</span>'));
define('MEMBER_STATUS_TEXT', array('Anggota Koperasi', 'ALB Anak', 'ALB WNA', 'ALB Luar Negeri', 'ALB Khusus', 'Calon Anggota'));

define('IS_MARRIED', array('Belum Menikah', 'Sudah Menikah'));
define('RELIGION', array('Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Kong Hu Cu', 'Aliran Kepercayaan', 'Lainnya'));
define('LAST_EDUCATION', array('Tidak Sekolah', 'SD', 'SLTP', 'SMU/SMK', 'Diploma 1,2,3', 'S1', 'S2', 'S3'));
define('AVERAGE_INCOME', array('-', '< 1jt', '1jt - 3jt', '3jt - 5jt', '5jt - 10jt', '>10jt'));
define('GENDER', array('Pria', 'Wanita'));
define('IDENTITY_TYPE', array('KTP', 'SIM', 'KK', 'KIA/KTM', 'Passport', 'Lainnya'));
define('NATIONALITY', array('WNI', 'WNA'));
define('WORKING_IN', array('Indonesia', 'Luar Negeri'));
define('RESIDENCE_STATUS', array('Milik Sendiri', 'Sewa/Kontrak', 'Menumpang', 'Ikut Orang Tua'));
define('BLOOD_TYPE', array('A', 'B', 'AB', 'O'));
define('SHIRT_SIZE', array('S', 'M', 'L', 'XL', 'XXL', 'XXXL'));
define('ENTRANCE_FEE_PAID_OFF', array('<span class="label label-danger">Belum Lunas</span>', '<span class="label label-success">Lunas</span>'));
define('IS_DIKSAR', array('<span class="label label-danger">Belum Diksar</span>', '<span class="label label-success">Sudah Diksar</span>'));

define('DATE_BEGIN_APPLICATION', '2019-07-01');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
