
# Tunggu sampai MySQL bisa diakses
echo "Menunggu MySQL agar siap..."
until nc -z -v -w30 mysql-note-list 3306
do
  echo "MySQL belum siap - menunggu..."
  sleep 5
done

echo "MySQL siap, menjalankan perintah: $@"
exec "$@"