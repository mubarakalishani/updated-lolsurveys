<?php

namespace App\Livewire\Advertise\Tasks;

use App\Models\SubmittedTaskProof;
use App\Models\Task;
use App\Models\User;
use App\Models\RejectApprovalReason;
use Livewire\WithPagination;
use Livewire\Component;

class Disputes extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $search = '';
    public $reasonExplained;
    public $reasonSelected;
    public $proofId;

    protected $rules = [
        'reasonExplained' => 'required|min:20',
    ];

    protected $listeners = [ 'updateModalContent' => 'setModalContent'];
    
    public function approve($proofId)
    {
        // dd($proofId);
        // $this->tab = $tab;
        $submittedTaskProof = SubmittedTaskProof::find($proofId);
        $amount = $submittedTaskProof->amount;
        $workerId = $submittedTaskProof->worker_id;
        $worker = User::find($workerId);
        $advertiseId = auth()->user()->id;
        $advertiser = User::find($advertiseId);
        
        if ($advertiser->deposit_balance < $amount) {
            return back()->with('error', 'your have insufficient funds, please top up first');
        }
        $advertiser->deductAdvertiserBalance($amount);

        $worker->addWorkerBalance($amount);

        $submittedTaskProof->update([ 'status' => 1 ]);

        session()->flash('message', 'Proof Approved Successfully!');
    }

    public function updatedReasonExplained(){
        $this->validate();
    }

    public function setModalContent($proofId)
    {
        $this->proofId = $proofId;
    }

    public function submitEmployerComment()
    {
    
        $this->validate();
        $reason = RejectApprovalReason::where('submitted_proof_id', $this->proofId)->first();
        $reason->update([
            'employer_comment' => $this->reasonExplained
        ]);
        
        $proof = SubmittedTaskProof::find($this->proofId);
        $proof->update(['status' => 6]);
        
    }

    public function render()
    {
        $disputeProofs = SubmittedTaskProof::byEmployer(auth()->user()->id)
        ->search($this->search)
        ->where('status', 5)
        ->orderBy('updated_at', 'desc')
        ->paginate($this->perPage);

        $employerTasks = Task::where('employer_id', auth()->user()->id)->where('status', '!=', 2)->get();

        return view('livewire.advertise.tasks.disputes', ['disputeProofs' => $disputeProofs, 'employerTasks' => $employerTasks]);
    }
}
