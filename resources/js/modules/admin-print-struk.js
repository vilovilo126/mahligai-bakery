// Cetak struk dari halaman detail pesanan admin.
// Menambahkan class `is-printing-struk` agar CSS print hanya
// menampilkan blok struktuk (#struk).
const printTrigger = document.querySelector('[data-print-struk-trigger]');

if (printTrigger) {
    printTrigger.addEventListener('click', (event) => {
        event.preventDefault();
        document.body.classList.add('is-printing-struk');
        window.print();
        document.body.classList.remove('is-printing-struk');
    });
}