    <div class="w-full max-w-xs mx-auto mt-4" x-data="{ open: false }">

        {{-- <div class="mb-4">
            <x-button label="Switch" @click="open = !open" class="bg-slate-400 px-4 py-2 rounded" />
        </div> --}}

        {{-- Writing to hr or all  --}}
        <h2 class="mb-4">
            သို့ / <br />
            <span class="ml-4" x-show="!open">HR</span>
            <span class="ml-4" x-show="open">Public</span>
        </h2>

        <div x-show="!open" class="mb-4">

            {{-- type of content  --}}

            <select wire:model="type_id" class="rounded w-full">
                <option value="" disabled selected>Select a type</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }} </option>
                @endforeach
            </select>

            @error('type_id')
                <div class="text-red-500 text-sm"> {{ $message }}</div>
            @enderror

            {{-- departments  --}}
            <label for="department">Term to</label>
            <select class="rounded w-full" wire:model="department_id" id="department">
                <option value="" selected disabled>Select a department</option>
                @foreach ($departments as $dep)
                    <option value="{{ $dep->id }}">{{ $dep->name }} </option>
                @endforeach
            </select>
            @error('department_id')
                <div class="text-red-500 text-sm"> {{ $message }}</div>
            @enderror
        </div>


        {{-- text input area  --}}

        <x-textarea wire:model='content' label="Write your" placeholder="write your notes" rows=10 />

        {{-- sumit button  --}}
        <div class="my-4">
            <x-button x-show="!open" label="send" wire:click="createHRPost" class="bg-slate-400 px-4 py-2 rounded" />
            <x-button x-show="open" label="send" wire:click="createPublicPost"
                class="bg-teal-400 px-[1.2rem] py-2 rounded" />
        </div>

        {{-- apines progress bar  --}}
        {{-- <div x-data="{
            progress: 0,
            progressInterval: null,
        }" x-init="progressInterval = setInterval(() => {
            progress = progress + 1;
            if (progress >= 100) {
                clearInterval(progressInterval);
            }
        }, 100);"
            class="relative w-full h-3 overflow-hidden rounded-full bg-neutral-100">
            <span :style="'width:' + progress + '%'" class="absolute w-24 h-full duration-300 ease-linear bg-teal-900"
                x-cloak></span>
        </div> --}}
        {{-- end apines progress bar  --}}
    </div>
