CREATE TABLE `user`
(
  gender INT DEFAULT 0,
  name VARCHAR(255) NOT NULL,
  type INT DEFAULT 0,
  password VARCHAR(255) NOT NULL,
  account VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  PRIMARY KEY (account)
);

CREATE TABLE system_administrator
(
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (account),
  FOREIGN KEY (account) REFERENCES `user`(account) ON DELETE CASCADE
);

CREATE TABLE dorm_manager
(
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (account),
  FOREIGN KEY (account) REFERENCES `user`(account) ON DELETE CASCADE
);

CREATE TABLE message
(
  message_id INT NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP ,
  content VARCHAR(255) NOT NULL,
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (message_id),
  FOREIGN KEY (account) REFERENCES `user`(account) ON DELETE CASCADE
);

CREATE TABLE announcement
(
  announcement_id INT NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(255) NOT NULL,
  content VARCHAR(255) NOT NULL,
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (announcement_id),
  FOREIGN KEY (account) REFERENCES `user`(account) ON DELETE CASCADE
);

CREATE TABLE rule
(
  rule_id INT NOT NULL AUTO_INCREMENT,
  content VARCHAR(255) NOT NULL,
  point INT NOT NULL,
  PRIMARY KEY (rule_id)
);

CREATE TABLE dormitory
(
  dormitory_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  PRIMARY KEY (dormitory_id)
);

CREATE TABLE student
(
  department VARCHAR(255) NOT NULL,
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (account),
  FOREIGN KEY (account) REFERENCES user(account) ON DELETE CASCADE
);

CREATE TABLE parent
(
  parent_account VARCHAR(255) NOT NULL,
  student_account VARCHAR(255) NOT NULL,
  PRIMARY KEY (parent_account),
  FOREIGN KEY (parent_account) REFERENCES `user`(account) ON DELETE CASCADE,
  FOREIGN KEY (student_account) REFERENCES student(account) ON DELETE CASCADE
);

CREATE TABLE apply_dorm
(
  state INT DEFAULT 0,
  apply_dorm_id INT NOT NULL AUTO_INCREMENT,
  `year` INT NOT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  first_priority_dorm int NOT NULL,
  second_priority_dorm int NOT NULL,
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (apply_dorm_id),
  FOREIGN KEY (account) REFERENCES student(account) ON DELETE CASCADE
);

CREATE TABLE parking_permit_record
(
  state INT DEFAULT 0,
  parking_permit_record_id INT NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  account VARCHAR(255) NOT NULL,
  PRIMARY KEY (parking_permit_record_id),
  FOREIGN KEY (account) REFERENCES parent(parent_account) ON DELETE CASCADE
);

CREATE TABLE public_equipment
(
  public_equipment_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  apply_fix_state INT DEFAULT 0,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  expired_year INT NOT NULL,
  dormitory_id INT NOT NULL,
  PRIMARY KEY (public_equipment_id),
  FOREIGN KEY (dormitory_id) REFERENCES dormitory(dormitory_id) ON DELETE CASCADE
);


CREATE TABLE room
(
  num_of_people INT NOT NULL,
  fee INT NOT NULL,
  clean_state INT DEFAULT 1,
  room_number VARCHAR(255) NOT NULL,
  dormitory_id INT NOT NULL,
  PRIMARY KEY (room_number, dormitory_id),
  FOREIGN KEY (dormitory_id) REFERENCES dormitory(dormitory_id) ON DELETE CASCADE
);

CREATE TABLE border
(
  type INT DEFAULT 0,
  apply_story_manager_state INT DEFAULT 0,
  `year` INT NOT NULL,
  account VARCHAR(255) NOT NULL,
  room_number VARCHAR(255) DEFAULT NULL,
  dormitory_id INT DEFAULT NULL,
  PRIMARY KEY (account, `year`),
  FOREIGN KEY (account) REFERENCES student(account) ON DELETE CASCADE,
  FOREIGN KEY (room_number, dormitory_id) REFERENCES room(room_number, dormitory_id) ON DELETE CASCADE
);

CREATE TABLE apply_change_dorm
(
  student_state INT DEFAULT 0,
  apply_change_dorm_id INT NOT NULL AUTO_INCREMENT,
  another_border VARCHAR(255) NOT NULL,
  final_state INT DEFAULT 0,
  change_dorm_id INT NOT NULL,
  change_room_number VARCHAR(255) NOT NULL,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (apply_change_dorm_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE

);

CREATE TABLE temporary_access_card_record
(
  state INT DEFAULT 0,
  temporary_access_card_record_id INT NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY (temporary_access_card_record_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);

CREATE TABLE roll_call_state_record
(
  roll_call_state_record_id INT NOT NULL AUTO_INCREMENT,
  state INT DEFAULT 0,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY (roll_call_state_record_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);

CREATE TABLE apply_quit_dorm
(
  state INT DEFAULT 0,
  apply_quit_dorm_id INT NOT NULL AUTO_INCREMENT,
  account VARCHAR(255),
  `year` INT NOT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (apply_quit_dorm_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);

CREATE TABLE violated_record
(
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  violated_record_id INT NOT NULL AUTO_INCREMENT,
  apply_cancel INT DEFAULT 0,
  rule_id INT NOT NULL,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY (violated_record_id),
  FOREIGN KEY (rule_id) REFERENCES rule(rule_id) ON DELETE CASCADE,
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);

CREATE TABLE equipment
(
  expired_year INT NOT NULL,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  apply_fix_state INT DEFAULT 0,
  equipment_id INT NOT NULL AUTO_INCREMENT,
  room_number VARCHAR(255) NOT NULL,
  dormitory_id INT NOT NULL,
  PRIMARY KEY (equipment_id),
  FOREIGN KEY (room_number, dormitory_id) REFERENCES room(room_number, dormitory_id) ON DELETE CASCADE
);

CREATE TABLE entry_and_exit_dormitory_record
(
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  state INT DEFAULT 0,
  entry_and_exit_dormitory_record_id INT NOT NULL AUTO_INCREMENT,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY (entry_and_exit_dormitory_record_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);

CREATE TABLE bill
(
  fee INT NOT NULL,
  type INT DEFAULT 0,
  bill_id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  state INT DEFAULT 0,
  account VARCHAR(255) NOT NULL,
  `year` INT NOT NULL,
  PRIMARY KEY (bill_id),
  FOREIGN KEY (account,`year`) REFERENCES border(account,`year`) ON DELETE CASCADE
);