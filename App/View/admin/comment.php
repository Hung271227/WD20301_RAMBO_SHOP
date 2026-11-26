<?php if ($edit): ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
  <h2 class="font-headline-sm font-bold mb-1">Sửa bình luận #<?= $edit['MaBL'] ?></h2>
  <p class="text-sm text-slate-500 mb-3"><?= e($edit['HoTen']) ?> • <?= e($edit['TenSP']) ?></p>
  <form method="post" action="admin.php?page=comment" class="grid md:grid-cols-4 gap-4">
    <?= csrf_field() ?><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= $edit['MaBL'] ?>">
    <label class="text-sm font-semibold md:col-span-3">Nội dung<textarea name="NoiDung" rows="3" required class="field mt-1"><?= e($edit['NoiDung']) ?></textarea></label>
    <label class="text-sm font-semibold">Số sao<select name="DanhGia" class="field mt-1"><?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>" <?= $edit['DanhGia'] == $i ? 'selected' : '' ?>><?= $i ?> sao</option><?php endfor; ?></select></label>
    <div class="md:col-span-4 flex gap-2"><button class="bg-primary-container hover:bg-primary text-white font-bold px-6 py-3 rounded-lg">Lưu</button><a href="admin.php?page=comment" class="px-6 py-3 rounded-lg border border-slate-300 font-bold">Hủy</a></div>
  </form>
</section>
<?php endif; ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <form method="get" class="p-4 flex gap-2 border-b"><input type="hidden" name="page" value="comment"><input name="q" value="<?= e($q) ?>" class="field !w-72" placeholder="Tìm theo nội dung, khách hàng, sản phẩm..."><button class="bg-inverse-surface text-white font-bold px-4 rounded-lg text-sm">Tìm</button></form>
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">Khách hàng</th><th>Sản phẩm</th><th>Nội dung</th><th class="text-center">Sao</th><th>Ngày</th><th class="p-3 text-right">Thao tác</th></tr></thead>
    <tbody class="divide-y"><?php if (!$rows): ?><tr><td colspan="6" class="p-8 text-center text-slate-500">Chưa có bình luận.</td></tr><?php endif; ?>
    <?php foreach ($rows as $c): ?>
      <tr class="hover:bg-slate-50 align-top"><td class="p-3 font-bold whitespace-nowrap"><?= e($c['HoTen']) ?></td>
        <td class="max-w-[200px]"><a class="text-primary font-semibold line-clamp-2" href="index.php?page=productdetail&amp;id=<?= $c['MaSP'] ?>" target="_blank"><?= e($c['TenSP']) ?></a></td>
        <td class="max-w-md text-slate-700"><?= nl2br(e($c['NoiDung'])) ?></td><td class="text-center whitespace-nowrap"><span class="text-amber-500 font-bold"><?= (int)$c['DanhGia'] ?> ★</span></td><td class="whitespace-nowrap"><?= dmy($c['NgayBL']) ?></td>
        <td class="p-3"><div class="flex justify-end gap-1.5"><a href="admin.php?page=comment&amp;edit=<?= $c['MaBL'] ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 hover:border-primary text-xs font-bold">Sửa</a>
          <form method="post" action="admin.php?page=comment" onsubmit="return confirm('Xóa bình luận này?')"><?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= $c['MaBL'] ?>"><button class="px-3 py-1.5 rounded-lg bg-error-container text-on-error-container hover:bg-red-200 text-xs font-bold">Xóa</button></form></div></td></tr>
    <?php endforeach; ?></tbody></table></div>
</section>
