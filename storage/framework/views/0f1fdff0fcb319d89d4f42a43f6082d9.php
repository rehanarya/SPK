
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'ttd',
    'label' => 'Tanda Tangan',
    'person' => null,
    'personHook' => null,
    'existing' => null,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name' => 'ttd',
    'label' => 'Tanda Tangan',
    'person' => null,
    'personHook' => null,
    'existing' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="signature-pad-wrap" data-signature-pad style="border: 1px solid var(--color-border); border-radius: 8px; padding: 12px; background: var(--color-bg-app);">
    <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 8px;">
        <span class="text-label"><?php echo e($label); ?></span>
        <div class="d-flex gap-2">
            <?php if($existing): ?>
                <button type="button" class="btn btn-secondary btn-sm" data-ttd-ganti>
                    <i class="bi bi-pencil"></i> Ganti
                </button>
            <?php endif; ?>
            <button type="button" class="btn btn-secondary btn-sm" data-ttd-hapus <?php echo e($existing ? 'hidden' : ''); ?>>
                <i class="bi bi-eraser"></i> Hapus / Ulangi
            </button>
        </div>
    </div>

    <?php if($existing): ?>
        
        <div data-ttd-lama style="margin-bottom: 8px;">
            <img src="<?php echo e(asset('storage/' . $existing)); ?>" alt="Tanda tangan tersimpan"
                 style="max-height: 90px; border: 1px dashed var(--color-border); border-radius: 4px; background: #fff;">
            <div class="form-helper">Tanda tangan tersimpan — klik "Ganti" untuk menggambar yang baru.</div>
        </div>
    <?php endif; ?>

    <canvas
        width="440" height="160" <?php echo e($existing ? 'hidden' : ''); ?>

        style="width: 100%; max-width: 440px; height: 160px; touch-action: none; background: #fff; border: 1px dashed var(--color-border); border-radius: 4px; cursor: crosshair;"
    ></canvas>

    <input type="hidden" name="<?php echo e($name); ?>" value="">

    <div class="text-meta" style="margin-top: 6px;">
        <?php if($personHook): ?>
            Nama: <strong data-hitung-teks="<?php echo e($personHook); ?>"><?php echo e($person ?? '—'); ?></strong>
        <?php elseif($person): ?>
            Nama: <strong><?php echo e($person); ?></strong>
        <?php endif; ?>
        <span style="float: right;">Opsional — kosongkan untuk tanda tangan basah di cetakan.</span>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('30594003-c910-4e2d-a93e-c4075366a692')): $__env->markAsRenderedOnce('30594003-c910-4e2d-a93e-c4075366a692'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-signature-pad]').forEach(function (wrap) {
        var canvas = wrap.querySelector('canvas');
        var hidden = wrap.querySelector('input[type="hidden"]');
        var hapus  = wrap.querySelector('[data-ttd-hapus]');
        var ganti  = wrap.querySelector('[data-ttd-ganti]');
        var lama   = wrap.querySelector('[data-ttd-lama]');
        var ctx    = canvas.getContext('2d');

        // "Ganti": sembunyikan gambar tersimpan, buka pad kosong
        if (ganti) {
            ganti.addEventListener('click', function () {
                if (lama) lama.hidden = true;
                canvas.hidden = false;
                hapus.hidden = false;
                ganti.hidden = true;
            });
        }
        var menggambar = false;
        var adaGoresan = false;

        ctx.lineWidth = 2.2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#1a1a2e';

        // Koordinat pointer relatif canvas (dukung skala CSS)
        function titik(e) {
            var r = canvas.getBoundingClientRect();
            return {
                x: (e.clientX - r.left) * (canvas.width / r.width),
                y: (e.clientY - r.top) * (canvas.height / r.height),
            };
        }

        function mulai(e) {
            e.preventDefault();
            menggambar = true;
            var t = titik(e);
            ctx.beginPath();
            ctx.moveTo(t.x, t.y);
        }

        function gores(e) {
            if (!menggambar) return;
            e.preventDefault();
            var t = titik(e);
            ctx.lineTo(t.x, t.y);
            ctx.stroke();
            adaGoresan = true;
        }

        function selesai() {
            if (!menggambar) return;
            menggambar = false;
            // Simpan sebagai dataURL PNG hanya bila ada goresan
            hidden.value = adaGoresan ? canvas.toDataURL('image/png') : '';
        }

        // Pointer Events mencakup mouse + touch + stylus
        canvas.addEventListener('pointerdown', mulai);
        canvas.addEventListener('pointermove', gores);
        canvas.addEventListener('pointerup', selesai);
        canvas.addEventListener('pointerleave', selesai);

        hapus.addEventListener('click', function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            hidden.value = '';
            adaGoresan = false;
        });
    });
});
</script>
<?php endif; ?>
<?php /**PATH A:\SKRIPSI\Sistem\resources\views/components/signature-pad.blade.php ENDPATH**/ ?>