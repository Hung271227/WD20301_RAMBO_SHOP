<section class="bg-surface-container-lowest rounded-xl custom-shadow-card border border-slate-100 overflow-hidden">
  <div class="p-4 border-b space-y-3">
    <div class="flex gap-2 overflow-x-auto no-scrollbar">
      <a href="admin.php?page=order" class="whitespace-nowrap px-3.5 py-1.5 rounded-full text-sm font-bold <?= $status === '' ? 'bg-inverse-surface text-white' : 'bg-slate-100 hover:bg-slate-200' ?>">Tất cả (<?= array_sum($counts) ?>)</a>
      <?php foreach (ORDER_STATUSES as $s): ?><a href="admin.php?page=order&amp;status=<?= urlencode($s) ?>" class="whitespace-nowrap px-3.5 py-1.5 rounded-full text-sm font-bold <?= $status === $s ? 'bg-inverse-surface text-white' : 'bg-slate-100 hover:bg-slate-200' ?>"><?= $s ?> (<?= (int)($counts[$s] ?? 0) ?>)</a><?php endforeach; ?>
    </div>
    <form method="get" class="flex flex-wrap gap-2 items-end"><input type="hidden" name="page" value="order"><?php if ($status): ?><input type="hidden" name="status" value="<?= e($status) ?>"><?php endif; ?>
      <input name="q" value="<?= e($q) ?>" class="field !w-64" placeholder="Mã đơn, tên khách, email, SĐT...">
      <label class="text-xs font-semibold">Từ ngày<input type="date" name="from" value="<?= e($from) ?>" class="field !py-2 mt-0.5"></label>
      <label class="text-xs font-semibold">Đến ngày<input type="date" name="to" value="<?= e($to) ?>" class="field !py-2 mt-0.5"></label>
      <button class="bg-inverse-surface text-white font-bold px-4 py-2.5 rounded-lg text-sm">Tìm kiếm</button><a href="admin.php?page=order" class="px-4 py-2.5 rounded-lg border border-slate-300 text-sm font-bold">Xóa lọc</a></form>
  </div>
  <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead class="bg-slate-50"><tr class="text-left text-xs uppercase text-slate-500"><th class="p-3">Mã đơn</th><th>Khách hàng</th><th>Ngày đặt</th><th class="text-center">SL</th><th>Thanh toán</th><th class="text-right">Tổng tiền</th><th class="text-center">Trạng thái</th><th class="p-3"></th></tr></thead>
    <tbody class="divide-y"><?php if (!$rows): ?><tr><td colspan="8" class="p-8 text-center text-slate-500">Không có đơn hàng phù hợp.</td></tr><?php endif; ?>
    <?php foreach ($rows as $o): ?>
      <tr class="hover:bg-slate-50"><td class="p-3 font-bold"><a class="text-primary" href="admin.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>">#RAMBO-<?= $o['MaDH'] ?></a></td>
        <td><p class="font-semibold"><?= e($o['TenKH']) ?></p><p class="text-xs text-slate-500"><?= e($o['Sdt']) ?></p></td><td><?= dmyhi($o['NgayDat']) ?></td>
        <td class="text-center"><?= (int)$o['SoMon'] ?></td><td><?= e($o['PhuongThuc']) ?></td><td class="text-right font-bold"><?= money($o['TongTien']) ?></td>
        <td class="text-center"><?= status_badge($o['TrangThai']) ?></td>
        <td class="p-3 text-right"><a href="admin.php?page=orderdetail&amp;id=<?= $o['MaDH'] ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 hover:border-primary text-xs font-bold">Chi tiết</a></td></tr>
    <?php endforeach; ?></tbody></table></div>
</section>
