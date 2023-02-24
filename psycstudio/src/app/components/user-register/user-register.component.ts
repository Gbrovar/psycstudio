import { Component , OnInit} from '@angular/core';

@Component({
  selector: 'user-register',
  templateUrl: './user-register.component.html',
  styleUrls: ['./user-register.component.css']
})
export class UserRegisterComponent implements OnInit{
  public page_title: string;

  constructor(){
    this.page_title = 'Registrate';
  }

  ngOnInit() {

  }


}
