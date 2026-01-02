<?php $__env->startSection('content'); ?>
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">
    
    <div class="flex-1 flex overflow-hidden pb-8">
        
        <div class="w-1/2 pr-2 border-r border-[var(--pip-green)]/50 overflow-y-auto">
            <ul class="space-y-1" id="items-list" role="listbox">
                <?php
                    $currentItems = match($tab) {
                        'weapons' => $weapons,
                        'apparel' => $apparel,
                        'aid' => $aid,
                        'misc' => $misc,
                        'ammo' => $ammo,
                        default => $weapons
                    };
                ?>

                <?php $__currentLoopData = $currentItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li onclick="selectItem(this)"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { selectItem(this); event.preventDefault(); }"
                        tabindex="0"
                        role="option"
                        aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                        
                        class="item-row group flex justify-between px-2 py-0.5 cursor-pointer 
                               border border-transparent outline-none
                               hover:bg-[var(--pip-green)] hover:text-black 
                               focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)]
                               <?php echo e($loop->first ? 'bg-[var(--pip-green)] text-black active-item' : ''); ?>"

                        data-name="<?php echo e($item->name); ?>"
                        data-wg="<?php echo e($item->weight ?? 0); ?>"
                        data-val="<?php echo e($item->value ?? 0); ?>"
                        data-stat="<?php echo e($tab == 'weapons' ? ($item->damage ?? 0) : ($tab == 'apparel' ? ($item->dr ?? 0) : ($item->effect ?? '-'))); ?>"
                        data-cond="<?php echo e($item->condition ?? 100); ?>"
                        >
                        
                        <span class="truncate"><?php echo e($item->name); ?></span>
                        <?php if(isset($item->quantity)): ?>
                            <span>(<?php echo e($item->quantity); ?>)</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="w-1/2 pl-4 flex flex-col items-center pt-4">
            <div class="w-32 h-32 mb-4 flex items-center justify-center opacity-80">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-24 h-24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h2v5zm0 4h-2v-2h2v2z"/>
                </svg>
            </div>

            <div class="w-full text-lg mt-auto mb-4 uppercase">
                
                <div class="grid grid-cols-3 border-t-2 border-b-2 border-[var(--pip-green)] mb-2">
                    <div class="p-1 border-r border-[var(--pip-green)]">
                        <?php if($tab == 'weapons'): ?> DAM 
                        <?php elseif($tab == 'apparel'): ?> DR 
                        <?php else: ?> EFF <?php endif; ?> 
                        <span class="float-right" id="detail-stat">
                            <?php echo e($currentItems->first() ? ($tab == 'weapons' ? $currentItems->first()->damage : ($tab == 'apparel' ? $currentItems->first()->dr : ($currentItems->first()->effect ?? '-'))) : '-'); ?>

                        </span>
                    </div>
                    
                    <div class="p-1 border-r border-[var(--pip-green)]">WG <span class="float-right" id="detail-wg"><?php echo e($currentItems->first()->weight ?? 0); ?></span></div>
                    <div class="p-1">VAL <span class="float-right" id="detail-val"><?php echo e($currentItems->first()->value ?? 0); ?></span></div>
                </div>

                <?php if(in_array($tab, ['weapons', 'apparel'])): ?>
                    <div class="flex items-center gap-2">
                        <span>CND</span>
                        <div class="flex-1 h-4 border border-[var(--pip-green)] p-0.5">
                            <div id="detail-cnd" class="h-full bg-[var(--pip-green)]" style="width: <?php echo e($currentItems->first()->condition ?? 100); ?>%"></div>
                        </div>
                    </div>
                    <div class="text-right text-sm mt-1 opacity-80 lowercase first-letter:uppercase">Item Condition</div>
                <?php endif; ?>
                
                <?php if($tab == 'aid'): ?>
                    <div class="border-t border-[var(--pip-green)] mt-2 pt-1 text-sm">
                        EFFECTS: <span id="detail-effect-text"><?php echo e($currentItems->first()->effect ?? 'None'); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="flex justify-between text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist">
        <?php $__currentLoopData = ['weapons', 'apparel', 'aid', 'misc', 'ammo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="?tab=<?php echo e($cat); ?>" 
               role="tab"
               aria-selected="<?php echo e($tab == $cat ? 'true' : 'false'); ?>"
               class="focus:outline-none focus:bg-[var(--pip-dim)] focus:border focus:border-[var(--pip-green)]
                      <?php echo e($tab == $cat ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:text-[var(--pip-green)] hover:opacity-100'); ?>">
               <?php echo e(ucfirst($cat)); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<script>
    function selectItem(el) {
        document.querySelectorAll('.item-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black', 'active-item');
            li.setAttribute('aria-selected', 'false');
        });

        el.classList.add('bg-[var(--pip-green)]', 'text-black', 'active-item');
        el.setAttribute('aria-selected', 'true');
        el.focus(); 

        const wg = el.getAttribute('data-wg');
        const val = el.getAttribute('data-val');
        const stat = el.getAttribute('data-stat');
        const cond = el.getAttribute('data-cond');

        if(document.getElementById('detail-wg')) document.getElementById('detail-wg').innerText = wg;
        if(document.getElementById('detail-val')) document.getElementById('detail-val').innerText = val;
        if(document.getElementById('detail-stat')) document.getElementById('detail-stat').innerText = stat;
        if(document.getElementById('detail-effect-text')) document.getElementById('detail-effect-text').innerText = stat;
        
        const cndBar = document.getElementById('detail-cnd');
        if(cndBar) {
            cndBar.style.width = cond + '%';
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\BoheN\Downloads\Aplikacje Internetowe projekt\pipboy\resources\views/items.blade.php ENDPATH**/ ?>