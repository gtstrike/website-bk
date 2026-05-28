function onFormSubmit(e) {
  const sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Form Responses 1");

  const row = e.range.getRow();
  const data = sheet.getRange(row, 1, 1, sheet.getLastColumn()).getValues()[0];

  const email = data[1];
  const nama = data[2];
  const tanggal = data[5];
  const waktu = data[6];

  // EMAIL ADMIN
  const adminEmail = Session.getEffectiveUser().getEmail();
  
  const lastRow = sheet.getLastRow();
  const all = sheet.getRange(2, 6, lastRow - 1, 2).getValues();

  let duplicate = false;

  for (let i = 0; i < all.length; i++) {
    const t = all[i][0];
    const w = all[i][1];

    // Skip row yang baru masuk
    if (i + 2 === row) continue;

    if (String(t) === String(tanggal) && String(w) === String(waktu)) {
      duplicate = true;
      break;
    }
  }

  if (duplicate) {

    // EMAIL KE USER
    MailApp.sendEmail({
      to: email,
      subject: "Konsultasi GAGAL",
      htmlBody: `
        <div>
          <h2 style="color:red">Jadwal Tidak Tersedia</h2>
          <p>Halo ${nama}, jadwal ${tanggal} ${waktu} sudah penuh.</p>
        </div>
      `
    });

    // EMAIL KE ADMIN
    MailApp.sendEmail({
      to: adminEmail,
      subject: "Booking GAGAL",
      htmlBody: `
        <div>
          <h2 style="color:red">Booking Ditolak</h2>
          <p><b>Nama:</b> ${nama}</p>
          <p><b>Email:</b> ${email}</p>
          <p><b>Tanggal:</b> ${tanggal}</p>
          <p><b>Waktu:</b> ${waktu}</p>
          <p>Alasan: Jadwal sudah penuh.</p>
        </div>
      `
    });

  } else {

    // EMAIL KE USER
    MailApp.sendEmail({
      to: email,
      subject: "Konsultasi BERHASIL",
      htmlBody: `
        <div>
          <h2 style="color:green">Booking Berhasil</h2>
          <p>Halo ${nama}, jadwal kamu sudah dikonfirmasi.</p>
          <p>${tanggal} - ${waktu}</p>
        </div>
      `
    });

    // EMAIL KE ADMIN
    MailApp.sendEmail({
      to: adminEmail,
      subject: "Booking BERHASIL",
      htmlBody: `
        <div>
          <h2 style="color:green">Booking Baru</h2>
          <p><b>Nama:</b> ${nama}</p>
          <p><b>Email:</b> ${email}</p>
          <p><b>Tanggal:</b> ${tanggal}</p>
          <p><b>Waktu:</b> ${waktu}</p>
        </div>
      `
    });
  }
}
