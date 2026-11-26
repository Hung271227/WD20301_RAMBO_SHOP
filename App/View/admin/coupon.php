<?php if ($form !== null): $f = $form + ['MaGG' => 0, 'Code' => '', 'LoaiGiam' => 'phantram', 'MucGiaGiam' => '', 'DieuKienGiam' => 0, 'SoLuong' => 100, 'NgayHetHan' => date('Y-m-d', strtotime('+3 months'))]; ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
  <h2 class="font-headline-sm font-bold mb-4"><?= $f['MaGG'] ? 'Sửa mã giảm giá #' . $f['MaGG'] : 'Thêm mã giảm giá' ?></h2>
  <form method="post" action="admin.php?page=coupon" class="grid md:grid-cols-3 gap-4">
    <?= csrf_field() ?><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)$f['MaGG'] ?>">
    <label class="text-sm font-semibold">Mã code *<input name="Code" required class="field mt-1 uppercase" value="<?= e($f['Code']) ?>" placeholder="RAMBOVIP"></label>
    <label class="text-sm font-semibold">Loại giảm<select name="LoaiGiam" class="field mt-1"><option value="phantram" <?= $f['LoaiGiam'] === 'phantram' ? 'selected' : '' ?>>Giảm theo %</option><option value="tien" <?= $f['LoaiGiam'] === 'tien' ? 'selected' : '' ?>>Giảm số tiền (đ)</option></select></label>
    <label class="text-sm font-semibold">Mức giảm *<input type="number" min="1" name="MucGiaGiam" required class="field mt-1" value="<?= e($f['MucGiaGiam']) ?>" placeholder="10 hoặc 100000"></label>
    <label class="text-sm font-semibold">Điều kiện: đơn tối thiểu (đ)<input type="number" min="0" name="DieuKienGiam" class="field mt-1" value="<?= e($f['DieuKienGiam']) ?>"></label>
    <label class="text-sm font-semibold">Số lượt sử dụng<input type="number" min="0" name="SoLuong" required class="field mt-1" value="<?= e($f['SoLuong']) ?>"></label>
    <label class="text-sm font-semibold">Ngày hết hạn *<input type="date" name="NgayHetHan" required class="field mt-1" value="<?= e($f['NgayHetHan']) ?>"></label>
    <div class="md:col-span-3 flex gap-2"><button class="bg-primary-container hover:bg-primary text-white font-bold px-6 py-3 rounded-lg">Lưu mã giảm giá</button><a href="admin.php?page=coupon" class="px-6 py-3 rounded-lg border border-slate-300 font-bold">Hủy</a></div>
  </form>
</section>
<?php endif; ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <form method="get" class="p-4 flex gap-2 border-b items-center"><input type="hidden" name="page" value="coupon"><input name="q" value="<?= e($q) ?>" class="field !w-64" placeholder="Tìm theo mã code..."><button class="bg-inverse-surface text-white font-bold px-4 py-2.5 rounded-lg text-sm">Tìm</button>
    <a href="admin.php?page=coupon&amp;new=1" class="ml-auto bg-primary-container hover:bg-primary text-white font-bold px-4 py-2.5 rounded-lg text-sm flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">add</span>Thêm mã</a></form>
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">Mã</th><th>Mức giảm</th><th class="text-right">Đơn tối thiểu</th><th class="text-center">Còn lại</th><th>Hết hạn</th><th class="text-center">Trạng thái</th><th class="p-3 text-right">Thao tác</th></tr></thead>
    <tbody class="divide-y"><?php if (!$rows): ?><tr><td colspan="7" class="p-8 text-center text-slate-500">Chưa có mã giảm giá.</td></tr><?php endif; ?>
    <?php foreach ($rows as $c): $exp = $c['NgayHetHan'] < date('Y-m-d'); $live = !$exp && $c['SoLuong'] > 0; ?>
      <tr class="hover:bg-slate-50"><td class="p-3 font-extrabold tracking-wider text-primary"><?= e($c['Code']) ?></td><td class="font-semibold"><?= e(Coupon::label($c)) ?></td>
        <td class="text-right"><?= money($c['DieuKienGiam']) ?></td><td class="text-center"><?= (int)$c['SoLuong'] ?></td><td><?= dmy($c['NgayHetHan']) ?></td>
        <td class="text-center"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold <?= $live ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-600' ?>"><?= $exp ? 'Hết hạn' : ($c['SoLuong'] > 0 ? 'Đang chạy' : 'Hết lượt') ?></span></td>
        <td class="p-3"><div class="flex justify-end gap-1.5"><a href="admin.php?page=coupon&amp;edit=<?= $c['MaGG'] ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 hover:border-primary text-xs font-bold">Sửa</a>
          <form method="post" action="admin.php?page=coupon" onsubmit="return confirm('Xóa mã giảm giá này?')"><?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= $c['MaGG'] ?>"><button class="px-3 py-1.5 rounded-lg bg-error-container text-on-error-container hover:bg-red-200 text-xs font-bold">Xóa</button></form></div></td></tr>
    <?php endforeach; ?></tbody></table></div>
</section>
