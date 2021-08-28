# Aplikasi Absensi Mata Kuliah Online dengan QRCode
## _Online Attendance System using QRCode_
## with Laravel Boilerplate (Current: Laravel 5.8)

## Cron Job command for refreshing schedule
php artisan schedule:run
## or in Windows
schtasks /create /tn "Laravel Scheduler" /sc minute /mo 1 /tr "D:\Belajar\PWEB\Cross-platform\absensi\schedule.cmd"
