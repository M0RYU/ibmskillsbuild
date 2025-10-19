@extends('layouts.admin')

@section('title', 'Admin - Alternatives Management')

@section('content')
<!-- Page Header with Gradient -->
<div class="gradient-bg rounded-3xl p-8 mb-8 text-white">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="flex-1">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-list-check text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-blue-100 text-sm font-medium">Admin Panel</span>
                    <h1 class="text-2xl md:text-3xl font-bold">Alternatives Management</h1>
                </div>
            </div>
            <p class="text-blue-100 text-lg">
                Manage alternatives for the decision support system
            </p>
        </div>
        
        <div>
            <a href="{{ route('admin.alternatives.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-white hover:bg-gray-100 rounded-xl text-gray-700 font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-plus-circle mr-2"></i>
                Add New Alternative
            </a>
        </div>
    </div>
</div>

<!-- Alternatives List -->
<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <div class="gradient-bg p-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                <i class="fas fa-database text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">All Alternatives</h2>
        </div>
    </div>
    
    <div class="p-6">
                @if(count($alternatives) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alternatives as $key => $alternative)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $alternative->name }}</td>
                                    <td>{{ $alternative->description }}</td>
                                    <td>{{ $alternative->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.alternatives.edit', $alternative->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.alternatives.destroy', $alternative->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this alternative? This will also delete all related assessments.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> No alternatives have been added yet.
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.alternatives.create') }}" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add First Alternative
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
