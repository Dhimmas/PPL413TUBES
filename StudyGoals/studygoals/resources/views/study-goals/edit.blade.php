@extends('layouts.app')

@section('content')
<div class="goal-form-container">
    <h2><i class="fas fa-edit"></i> Edit Goal</h2>

    <form method="POST" action="{{ route('study-goals.update', $goal->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="goal_title">Goal Title:</label>
            <input type="text" id="goal_title" name="goal_title" value="{{ $goal->title }}" required />
        </div>

        <div class="form-group">
            <label for="goal_description">Description:</label>
            <input type="text" id="goal_description" name="goal_description" value="{{ $goal->description }}" required />
        </div>

        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{ $goal->start_date }}" required />
        </div>

        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{ $goal->end_date }}" required />
        </div>

        <div class="form-group">
            <button type="submit" class="submit-btn">Update Goal</button>
        </div>
    </form>
</div>
@endsection
