<div>
    <div class="mt-3">
        <label for="receiverUnit" class="form-label">Unit Penerima</label>
        <select wire:model="receiverUnit" class="form-select" id="receiverUnit">
            <option selected>Pilih Unit Penerima</option>
            @foreach ($receiverUnits as $receiverUnit)
                <option value="{{ $receiverUnit->id }}">{{ $receiverUnit->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-3">
        <label for="receiver" class="form-label">Penerima</label>
        <select wire:model="receiver" class="form-select @error('receiver_id') is-invalid @enderror" id="receiver"
            name="receiver_id">
            @foreach ($receivers as $receiver)
                <option value="{{ $receiver->id }}">{{ $receiver->name }}</option>
            @endforeach
        </select>
        @error('receiver_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
