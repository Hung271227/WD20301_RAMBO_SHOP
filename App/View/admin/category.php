<?php $f = $edit ?: ['MaDM' => 0, 'TenDM' => '', 'MoTa' => '', 'Icon' => 'extension']; ?>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 p-5">
  <h2 class="font-headline-sm font-bold mb-3"><?= $edit ? 'Sửa danh mục #' . $edit['MaDM'] : 'Thêm danh mục mới' ?></h2>
  <form method="post" action="admin.php?page=category" class="grid md:grid-cols-4 gap-3 items-end">
    <?= csrf_field() ?><input type="hidden" name="do" value="save"><input type="hidden" name="id" value="<?= (int)$f['MaDM'] ?>">
    <label class="text-sm font-semibold">Tên danh mục *<input name="TenDM" required class="field mt-1" value="<?= e($f['TenDM']) ?>"></label>
    <label class="text-sm font-semibold">Mô tả ngắn<input name="MoTa" class="field mt-1" value="<?= e($f['MoTa']) ?>"></label>
    <label class="text-sm font-semibold">Icon (Material Symbols)<input name="Icon" class="field mt-1" value="<?= e($f['Icon']) ?>" placeholder="extension"></label>
    <div class="flex gap-2"><button class="bg-primary-container hover:bg-primary text-white font-bold px-5 py-3 rounded-lg"><?= $edit ? 'Lưu' : 'Thêm' ?></button><?php if ($edit): ?><a href="admin.php?page=category" class="px-5 py-3 rounded-lg border border-slate-300 font-bold">Hủy</a><?php endif; ?></div>
  </form>
</section>
<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">ID</th><th>Danh mục</th><th>Mô tả</th><th class="text-center">Sản phẩm</th><th class="text-center">Trạng thái</th><th class="text-right p-3">Thao tác</th></tr></thead>
    <tbody class="divide-y"><?php foreach ($rows as $r): ?>
      <tr class="hover:bg-slate-50 <?= $r['TrangThai'] ? '' : 'opacity-60' ?>">
        <td class="p-3 text-slate-500">#<?= $r['MaDM'] ?></td>
        <td class="font-bold"><span class="material-symbols-outlined text-primary text-[20px] mr-1"><?= e($r['Icon']) ?></span><?= e($r['TenDM']) ?></td>
        <td class="text-slate-600"><?= e($r['MoTa']) ?></td><td class="text-center"><?= (int)$r['SoSP'] ?></td>
        <td class="text-center"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold <?= $r['TrangThai'] ? 'bg-green-100 text-green-800' : 'bg-slate-200 text-slate-600' ?>"><?= $r['TrangThai'] ? 'Đang hiện' : 'Đã ẩn' ?></span></td>
        <td class="p-3"><div class="flex justify-end gap-1.5">
          <a href="admin.php?page=category&amp;edit=<?= $r['MaDM'] ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 hover:border-primary text-xs font-bold">Sửa</a>
          <form method="post" action="admin.php?page=category"><?= csrf_field() ?><input type="hidden" name="do" value="toggle"><input type="hidden" name="id" value="<?= $r['MaDM'] ?>"><button class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-xs font-bold"><?= $r['TrangThai'] ? 'Ẩn' : 'Hiện' ?></button></form>
          <form method="post" action="admin.php?page=category" onsubmit="return confirm('Xóa danh mục này?')"><?= csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= $r['MaDM'] ?>"><button class="px-3 py-1.5 rounded-lg bg-error-container text-on-error-container hover:bg-red-200 text-xs font-bold">Xóa</button></form>
        </div></td>
      </tr><?php endforeach; ?></tbody></table></div>
</section>
