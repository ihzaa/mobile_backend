rmdir -r .git
git init
git add .
git commit -m "first commit"
git branch -M main
git remote add origin %1
echo "YAY BERHASIL CONGRAT!"
PAUSE
