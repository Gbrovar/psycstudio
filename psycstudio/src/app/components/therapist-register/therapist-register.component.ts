import { Component , OnInit} from '@angular/core';

@Component({
  selector: 'therapist-register',
  templateUrl: './therapist-register.component.html',
  styleUrls: ['./therapist-register.component.css']
})
export class TherapistRegisterComponent implements OnInit{
  public page_title: string;

  constructor(){
    this.page_title = 'Registrate';
  }

  ngOnInit() {

  }

}
