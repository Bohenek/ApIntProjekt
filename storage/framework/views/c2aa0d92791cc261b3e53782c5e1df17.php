<?php $__env->startSection('content'); ?>
<div class="h-full flex flex-col relative text-[var(--pip-green)] tracking-wide">

    <div class="flex-1 flex pb-8 overflow-hidden">
        <div class="w-1/2 pr-2 border-r border-[var(--pip-green)]/50 overflow-y-auto">
            <ul class="space-y-2" role="listbox">
                <?php
                    $items = ($tab == 'quests') ? $quests : $notes;
                ?>

                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li onclick="showData(this, 'content-<?php echo e($item->id); ?>')"
                    onkeydown="if(event.key === 'Enter' || event.key === ' ') { showData(this, 'content-<?php echo e($item->id); ?>'); event.preventDefault(); }"
                    tabindex="0"
                    role="option"
                    aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                    
                    class="data-row px-2 cursor-pointer flex items-center
                           border border-transparent outline-none
                           hover:bg-[var(--pip-green)] hover:text-black
                           focus:bg-[var(--pip-dim)] focus:border-[var(--pip-green)]
                           <?php echo e($loop->first ? 'bg-[var(--pip-green)] text-black active-data' : ''); ?>">
                    
                    <?php if($tab == 'quests'): ?> 
                        <span class="mr-2 inline-block w-3 h-3 bg-current square-bullet <?php echo e($loop->first ? 'opacity-100' : 'opacity-0'); ?>"></span>
                    <?php endif; ?>
                    
                    <span class="truncate"><?php echo e($item->title); ?></span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="w-1/2 pl-4 overflow-y-auto relative">
            
            <?php if($items->isEmpty()): ?>
                <p>No data found.</p>
            <?php endif; ?>

            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="content-<?php echo e($item->id); ?>" class="data-content <?php echo e($loop->first ? '' : 'hidden'); ?>">
                    
                    <?php if($tab == 'quests'): ?>
                        <div class="text-right text-sm mb-4 opacity-80 uppercase tracking-widest">Show Location</div>
                        <h3 class="text-xl mb-4 uppercase font-bold border-b border-[var(--pip-green)] pb-1"><?php echo e($item->title); ?></h3>
                        
                        <p class="mb-6 text-lg opacity-90 leading-relaxed"><?php echo e($item->description); ?></p>

                        <ul class="space-y-4">
                            <li class="flex items-start gap-2 opacity-60">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 relative mt-1">
                                    <span class="absolute inset-0.5 bg-[var(--pip-green)]"></span>
                                </span>
                                <span>Quest objective completed.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="border border-[var(--pip-green)] w-4 h-4 block flex-shrink-0 mt-1"></span>
                                <span>Current objective for <?php echo e($item->title); ?>.</span>
                            </li>
                        </ul>

                    <?php elseif($tab == 'notes'): ?>
                        <div class="text-right text-sm mb-4 opacity-80 uppercase">Audio/Text</div>
                        <h3 class="text-lg mb-4 uppercase font-bold">> <?php echo e($item->title); ?></h3>
                        
                        <div class="text-xl leading-relaxed whitespace-pre-wrap">
<?php echo e($item->content); ?>

                        </div>
                        <div class="mt-8 opacity-70 text-right">-- END OF MESSAGE --</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>

    <div class="flex justify-between text-lg uppercase border-t-2 border-[var(--pip-green)] pt-1" role="tablist">
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">Local Map</a>
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">World Map</a>
        
        <a href="?tab=quests" role="tab" aria-selected="<?php echo e($tab == 'quests' ? 'true' : 'false'); ?>"
           class="focus:outline-none focus:bg-[var(--pip-dim)] focus:border focus:border-[var(--pip-green)]
                  <?php echo e($tab == 'quests' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100'); ?>">
           Quests
        </a>
        
        <a href="?tab=notes" role="tab" aria-selected="<?php echo e($tab == 'notes' ? 'true' : 'false'); ?>"
           class="focus:outline-none focus:bg-[var(--pip-dim)] focus:border focus:border-[var(--pip-green)]
                  <?php echo e($tab == 'notes' ? 'bg-[var(--pip-green)] text-black px-1' : 'opacity-70 hover:opacity-100'); ?>">
           Notes
        </a>
        
        <a href="#" class="opacity-50 hover:text-[var(--pip-green)]" role="tab" aria-disabled="true">Radio</a>
    </div>

</div>

<script>
    function showData(el, contentId) {
        document.querySelectorAll('.data-row').forEach(li => {
            li.classList.remove('bg-[var(--pip-green)]', 'text-black', 'active-data');
            li.setAttribute('aria-selected', 'false');
            const bullet = li.querySelector('.square-bullet');
            if(bullet) bullet.classList.add('opacity-0');
        });

        el.classList.add('bg-[var(--pip-green)]', 'text-black', 'active-data');
        el.setAttribute('aria-selected', 'true');
        el.focus();
        
        const bullet = el.querySelector('.square-bullet');
        if(bullet) bullet.classList.remove('opacity-0');

        document.querySelectorAll('.data-content').forEach(div => {
            div.classList.add('hidden');
        });
        
        const content = document.getElementById(contentId);
        if(content) {
            content.classList.remove('hidden');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\BoheN\Downloads\Aplikacje Internetowe projekt\pipboy\resources\views/data.blade.php ENDPATH**/ ?>