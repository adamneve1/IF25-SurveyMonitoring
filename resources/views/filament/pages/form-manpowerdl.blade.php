<x-filament-panels::page>
    <form method="post" wire:submit="save">
        {{ $this->form }}
        <button 
            type="submit" 
            class="mt-4 bg-amber-500 w-40 hover:bg-amber-600 text-black font-bold py-2 text-center transition duration-300 ease-in-out transform hover:scale-105 shadow-md"
        >
            Save
        </button>
    </form>
</x-filament-panels::page>
