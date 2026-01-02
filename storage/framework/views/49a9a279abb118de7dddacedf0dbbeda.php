<?php $__env->startSection('content'); ?>
<div class="h-full flex flex-col relative text-[var(--pip-green)]">

    <div class="flex-1 flex pb-8 overflow-hidden">
        <div class="w-1/2 pr-4 overflow-y-auto">
            <ul class="space-y-1" role="listbox">
                <?php
                    $listItems = match($tab) {
                        'special' => $specials,
                        'skills' => $skills,
                        'perks' => $perks,
                        default => collect()
                    };
                ?>

                <?php if($tab == 'status'): ?>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30">Vault Dweller - Level 16</li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30">HP: 320/350</li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30">AP: 85/85</li>
                    <li class="px-2 py-1 border-b border-[var(--pip-green)]/30">XP: 14500/18000</li>
                <?php else: ?>
                    <?php $__currentLoopData = $listItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li onclick="selectStat(this)"
                            onkeydown="if(event.key === 'Enter' || event.key === ' ') { selectStat(this); event.preventDefault(); }"
                            tabindex="0"
                            role="option"
                            aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                            
                            class="stat-row flex justify-between px-2 cursor-pointer 
                                   border border-transparent outline-none
                                   hover:bg-[var(--pip-green)] hover:text-black
                                   focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)]
                                   group <?php echo e($loop->first ? 'bg-[var(--pip-green)] text-black' : ''); ?>"
                            
                            data-desc="<?php echo e($item->description ?? ($item->name . ' governs your general capability.')); ?>">
                            
                            <span><?php echo e($item->name); ?></span>
                            <?php if(isset($item->value)): ?>
                                <span><?php echo e($item->value); ?> <?php if($tab=='skills'): ?> <span class="text-xs opacity-70">(-)</span> <?php endif; ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </div>

        <div class="w-1/2 flex flex-col items-center justify-between relative pl-4">
            
            <div class="mt-4 animate-pulse">
                <svg class="w-40 h-40 fill-current text-[var(--pip-green)]" viewBox="0 0 100 100">
                     <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="2" fill="none" />
                     <path d="M 30 65 Q 50 85 70 65" stroke="currentColor" stroke-width="3" fill="none" />
                     <circle cx="35" cy="40" r="5" />
                     <circle cx="65" cy="40" r="5" />
                     </svg>
            </div>

            <div class="border border-[var(--pip-green)] p-2 text-sm mt-auto w-full relative bg-black/50 min-h-[100px]">
                <div class="absolute -top-2 left-0 border-l border-t border-[var(--pip-green)] w-4 h-4"></div>
                <div class="absolute -bottom-2 right-0 border-r border-b border-[var(--pip-green)] w-4 h-4"></div>
                
                <p id="stat-description">
                    <?php if($listItems->isNotEmpty()): ?>
                        <?php echo e($listItems->first()->description ?? ($listItems->first()->name . ' information.')); ?>

                    <?php else: ?>
                        System functioning normally.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="flex justify-between text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist">
        <?php $__currentLoopData = ['status', 'special', 'skills', 'perks', 'general']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    function selectStat(el) {
        document.querySelectorAll('.stat-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black');
            li.setAttribute('aria-selected', 'false');
        });

        el.classList.add('bg-[var(--pip-green)]', 'text-black');
        el.setAttribute('aria-selected', 'true');
        el.focus();

        const desc = el.getAttribute('data-desc');
        document.getElementById('stat-description').innerText = desc;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\BoheN\Downloads\Aplikacje Internetowe projekt\pipboy\resources\views/stats.blade.php ENDPATH**/ ?>