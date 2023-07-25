<div id="app">
    <label for="checkbox"><input type="checkbox" id="checkbox" v-model="myVar" /> Show unlocked achievements</label>
    <h1 class="text-neutral-300 text-2xl mb-2 ml-2"><strong><?php echo $game->name ?></strong></h1>
    <h2 class="text-neutral-300 text-lg mb-4 ml-2">Achievements</h2>
    <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        <div class="flex flex-col justify-between w-full bg-neutral-800 p-2 rounded" :class="{ 'opacity-60': achievement.achieved }" v-for="achievement in achievements">
            <div class="flex">
                <div :style="{ 'background-image': 'url(' + (achievement.achieved ? achievement.icon : achievement.icongray) + ')', 'width': '50px', 'height': '50px' }" class="bg-cover flex-none mr-2"></div>
                <div>
                    <p class="text-lg font-bold line-clamp-1 text-neutral-300">{{ achievement.display_name }}</p>
                    <p class="text-sm line-clamp-2 hover:line-clamp-none text-neutral-400">{{ achievement.description }}</p>
                </div>
            </div>
            <div class="text-right text-sm text-neutral-100 mt-2">{{ achievement.unlocked_at }}</div>
        </div>
    </div>
</div>
<script>
    const { createApp, ref, computed } = Vue



    const myVar = ref(false)
    const achievements = computed(() => {
        return [<?php echo implode(", ", array_map(function($achievement) { return $achievement->getVars(); }, $achievements)) ?>].filter((ach) => !ach.achieved || !!ach.achieved && myVar.value )
    })

    createApp({

        setup() {
            return {
                achievements, myVar
            }
        }
    }).mount('#app')
</script>