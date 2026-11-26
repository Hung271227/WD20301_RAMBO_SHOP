<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <form method="get" class="p-4 flex gap-2 border-b"><input type="hidden" name="page" value="user"><input name="q" value="<?= e($q) ?>" class="field !w-72" placeholder="Tìm theo tên, email, số điện thoại..."><button class="bg-inverse-surface text-white font-bold px-4 rounded-lg text-sm">Tìm</button></form>
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">Khách hàng</th><th>Liên hệ</th><th class="text-center">Đơn</th><th class="text-right">Đã mua</th><th class="text-center">Quyền</th><th class="text-center">Trạng thái</th><th class="text-right p-3">Thao tác</th></tr></thead>
    <tbody class="divide-y"><?php foreach ($rows as $r): $self = $r['MaKH'] == current_user()['MaKH']; ?>
      <tr class="hover:bg-slate-50 <?= $r['TrangThai'] ? '' : 'bg-red-50/50' ?>">
        <td class="p-3"><p class="font-bold"><?= e($r['HoTen']) ?><?= $self ? ' <span class="text-xs text-primary">(bạn)</span>' : '' ?></p><p class="text-xs text-slate-500">#<?= $r['MaKH'] ?> • Tham gia <?= dmy($r['NgayTao']) ?></p></td>
        <td><p><?= e($r['Email']) ?></p><p class="text-xs text-slate-500"><?= e($r['Sdt']) ?></p></td>
        <td class="text-center font-bold"><?= (int)$r['SoDon'] ?></td><td class="text-right font-bold"><?= money($r['TongMua']) ?></td>
        <td class="text-center">
          <?php if ($self): ?><span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary">Admin</span>
          <?php else: ?><form method="post" action="admin.php?page=user" class="inline-flex"><?= csrf_field() ?><input type="hidden" name="do" value="role"><input type="hidden" name="id" value="<?= $r['MaKH'] ?>">
            <select name="VaiTro" onchange="if(confirm('Đổi quyền của <?= e(addslashes($r['HoTen'])) ?>?')) this.form.submit(); else this.value='<?= $r['VaiTro'] ?>'" class="field !py-1 !px-2 !w-auto text-xs font-bold">
              <option value="khach" <?= $r['VaiTro'] === 'khach' ? 'selected' : '' ?>>Khách hàng</option><option value="admin" <?= $r['VaiTro'] === 'admin' ? 'selected' : '' ?>>Admin</option></select></form><?php endif; ?>
        </td>
        <td class="text-center"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold <?= $r['TrangThai'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>"><?= $r['TrangThai'] ? 'Hoạt động' : 'Đã khóa' ?></span></td>
        <td class="p-3 text-right"><?php if (!$self): ?>
          <form method="post" action="admin.php?page=user" onsubmit="return confirm('<?= $r['TrangThai'] ? 'Khóa' : 'Mở khóa' ?> tài khoản này?')"><?= csrf_field() ?><input type="hidden" name="do" value="lock"><input type="hidden" name="id" value="<?= $r['MaKH'] ?>">
            <button class="px-3 py-1.5 rounded-lg text-xs font-bold <?= $r['TrangThai'] ? 'bg-error-container text-on-error-container hover:bg-red-200' : 'bg-green-100 text-green-800 hover:bg-green-200' ?>"><?= $r['TrangThai'] ? 'Khóa tài khoản' : 'Mở khóa' ?></button></form><?php endif; ?></td>
      </tr><?php endforeach; ?></tbody></table></div>
</section>
