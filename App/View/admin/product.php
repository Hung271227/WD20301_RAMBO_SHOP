<?php if ($form !== null):
  $f = $form + ['MaSP' => 0, 'MaDM' => 0, 'MaHang' => '', 'TenSP' => '', 'Gia' => '', 'GiaGoc' => 0, 'SoLuongTonKho' => 0, 'SoManh' => 0, 'DoTuoi' => '', 'MoTa' => '', 'HinhAnh' => '', 'TrangThai' => 1];
  $isUrl = preg_match('#^https?://#', $f['HinhAnh']); ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
  <h2 class="font-headline-sm font-bold mb-4"><?= $f['MaSP'] ? 'Sửa sản phẩm #' . $f['MaSP'] : 'Thêm sản phẩm mới' ?></h2>
  <form method="post" enctype="multipart/form-data" action="admin.php?page=product" class="grid md:grid-cols-3 gap-4">
    <?= csrf_field() ?><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)$f['MaSP'] ?>">
    <label class="text-sm font-semibold md:col-span-2">Tên sản phẩm *<input name="TenSP" required class="field mt-1" value="<?= e($f['TenSP']) ?>"></label>
    <label class="text-sm font-semibold">Mã hàng (SKU)<input name="MaHang" class="field mt-1" value="<?= e($f['MaHang']) ?>" placeholder="LEGO-42143"></label>
    <label class="text-sm font-semibold">Danh mục *<select name="MaDM" required class="field mt-1"><option value="">-- Chọn --</option><?php foreach ($cats as $c): ?><option value="<?= $c['MaDM'] ?>" <?= $f['MaDM'] == $c['MaDM'] ? 'selected' : '' ?>><?= e($c['TenDM']) ?><?= $c['TrangThai'] ? '' : ' (ẩn)' ?></option><?php endforeach; ?></select></label>
    <label class="text-sm font-semibold">Giá bán (đ) *<input type="number" min="1" name="Gia" required class="field mt-1" value="<?= e($f['Gia']) ?>"></label>
    <label class="text-sm font-semibold">Giá gốc (đ) <span class="font-normal text-slate-500">- để 0 nếu không giảm giá</span><input type="number" min="0" name="GiaGoc" class="field mt-1" value="<?= e($f['GiaGoc']) ?>"></label>
    <label class="text-sm font-semibold">Số lượng tồn kho *<input type="number" min="0" name="SoLuongTonKho" required class="field mt-1" value="<?= e($f['SoLuongTonKho']) ?>"></label>
    <label class="text-sm font-semibold">Số mảnh ghép<input type="number" min="0" name="SoManh" class="field mt-1" value="<?= e($f['SoManh']) ?>"></label>
    <label class="text-sm font-semibold">Độ tuổi<input name="DoTuoi" class="field mt-1" value="<?= e($f['DoTuoi']) ?>" placeholder="9+"></label>
    <label class="text-sm font-semibold md:col-span-3">Mô tả<textarea name="MoTa" rows="3" class="field mt-1"><?= e($f['MoTa']) ?></textarea></label>
    <div class="md:col-span-3 grid md:grid-cols-3 gap-4 items-start">
      <div class="text-sm font-semibold">Ảnh hiện tại<div class="mt-1 w-28 h-28 bg-[#F8F9FA] rounded-lg border flex items-center justify-center overflow-hidden"><img src="<?= e(img($f['HinhAnh'])) ?>" class="w-full h-full object-contain" alt=""></div></div>
      <label class="text-sm font-semibold">Tải ảnh lên (jpg, png, webp - tối đa 3MB)<input type="file" name="HinhAnh" accept="image/*" class="field mt-1 !p-2"></label>
      <label class="text-sm font-semibold">...hoặc dán link ảnh<input name="HinhAnhUrl" class="field mt-1" value="<?= $isUrl ? e($f['HinhAnh']) : '' ?>" placeholder="https://..."></label>
    </div>
    <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="TrangThai" value="1" class="rounded text-primary focus:ring-primary" <?= $f['TrangThai'] ? 'checked' : '' ?>>Hiển thị trên website</label>
    <div class="md:col-span-3 flex gap-2"><button class="bg-primary-container hover:bg-primary text-white font-bold px-6 py-3 rounded-lg">Lưu sản phẩm</button><a href="admin.php?page=product" class="px-6 py-3 rounded-lg border border-slate-300 font-bold">Hủy</a></div>
  </form>
</section>
<?php endif; ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <form method="get" class="p-4 flex flex-wrap gap-2 items-center border-b">
    <input type="hidden" name="page" value="product">
    <input name="q" value="<?= e($q) ?>" class="field !w-64" placeholder="Tìm tên hoặc mã hàng...">
    <select name="cat" class="field !w-48"><option value="0">Tất cả danh mục</option><?php foreach ($cats as $c): ?><option value="<?= $c['MaDM'] ?>" <?= $cat == $c['MaDM'] ? 'selected' : '' ?>><?= e($c['TenDM']) ?></option><?php endforeach; ?></select>
    <select name="st" class="field !w-40"><option value="">Mọi trạng thái</option><option value="1" <?= $st === '1' ? 'selected' : '' ?>>Đang hiện</option><option value="0" <?= $st === '0' ? 'selected' : '' ?>>Đã ẩn</option></select>
    <button class="bg-inverse-surface text-white font-bold px-4 py-2.5 rounded-lg text-sm">Lọc</button>
    <a href="admin.php?page=product&amp;new=1" class="ml-auto bg-primary-container hover:bg-primary text-white font-bold px-4 py-2.5 rounded-lg text-sm flex items-center gap-1"><span class="material-symbols-outlined text-[18px]">add</span>Thêm sản phẩm</a>
  </form>
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">Sản phẩm</th><th>Danh mục</th><th class="text-right">Giá bán</th><th class="text-center">Tồn kho</th><th class="text-center">Trạng thái</th><th class="text-right p-3">Thao tác</th></tr></thead>
    <tbody class="divide-y"><?php if (!$rows): ?><tr><td colspan="6" class="p-8 text-center text-slate-500">Không có sản phẩm nào.</td></tr><?php endif; ?>
    <?php foreach ($rows as $r): ?>
      <tr class="hover:bg-slate-50 <?= $r['TrangThai'] ? '' : 'opacity-60' ?>">
        <td class="p-3"><div class="flex items-center gap-3"><img src="<?= e(img($r['HinhAnh'])) ?>" class="w-12 h-12 object-contain bg-[#F8F9FA] rounded" alt=""><div class="min-w-0 max-w-xs"><p class="font-bold line-clamp-1"><?= e($r['TenSP']) ?></p><p class="text-xs text-slate-500"><?= e($r['MaHang']) ?> • #<?= $r['MaSP'] ?></p></div></div></td>
        <td><?= e($r['TenDM']) ?></td>
        <td class="text-right"><strong><?= money($r['Gia']) ?></strong><?php if ($r['GiaGoc'] > $r['Gia']): ?><br><span class="text-xs text-slate-400 line-through"><?= money($r['GiaGoc']) ?></span><?php endif; ?></td>
        <td class="text-center font-bold <?= $r['SoLuongTonKho'] <= 5 ? 'text-error' : '' ?>"><?= (int)$r['SoLuongTonKho'] ?></td>
        <td class="text-center"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold <?= $r['TrangThai'] ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-600' ?>"><?= $r['TrangThai'] ? 'Đang hiện' : 'Đã ẩn' ?></span></td>
        <td class="p-3"><div class="flex justify-end gap-1.5">
          <a href="admin.php?page=product&amp;edit=<?= $r['MaSP'] ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 hover:border-primary text-xs font-bold">Sửa</a>
          <form method="post" action="admin.php?page=product"><?= csrf_field() ?><input type="hidden" name="do" value="toggle"><input type="hidden" name="id" value="<?= $r['MaSP'] ?>"><button class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-bold"><?= $r['TrangThai'] ? 'Ẩn' : 'Hiện' ?></button></form>
          <form method="post" action="admin.php?page=product" onsubmit="return confirm('Xóa sản phẩm này?')"><?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= $r['MaSP'] ?>"><button class="px-3 py-1.5 rounded-lg bg-error-container text-on-error-container hover:bg-red-200 text-xs font-bold">Xóa</button></form>
        </div></td></tr>
    <?php endforeach; ?></tbody></table></div>
</section>
