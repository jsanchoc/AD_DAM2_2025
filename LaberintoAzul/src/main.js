import Phaser from "phaser";

const config = {
  type: Phaser.AUTO,
  width: 800,
  height: 600,
  backgroundColor: "#000000",
  physics: {
    default: "arcade",
    arcade: { debug: false },
  },
  scene: {
    create: create,
    update: update,
  },
};

const game = new Phaser.Game(config);

let player, cursors, walls, stars, goal;
let collectedCount = 0;
const TOTAL_STARS = 7;
const VELOCIDAD = 120;

function create() {
  let graphics = this.make.graphics({ x: 0, y: 0, add: false });
  graphics.fillStyle(0xffffff);
  graphics.fillRect(0, 0, 32, 32);
  graphics.generateTexture("block", 32, 32);
  graphics.destroy();

  walls = this.physics.add.staticGroup();

  createWall(this, 400, 10, 800, 20);
  createWall(this, 400, 590, 800, 20);
  createWall(this, 10, 300, 20, 600);
  createWall(this, 790, 300, 20, 600);

  createWall(this, 120, 150, 20, 600);

  createWall(this, 550, 400, 250, 20);
  createWall(this, 300, 500, 20, 600);
  createWall(this, 650, 150, 300, 20);
  createWall(this, 600, 200, 20, 80);
  createWall(this, 600, 550, 20, 80);

  player = this.physics.add.sprite(50, 50, "block").setDisplaySize(16, 16);
  player.setTint(0x0000ff);
  player.setCollideWorldBounds(true);
  player.setVelocityX(VELOCIDAD);

  goal = this.physics.add.sprite(750, 50, "block").setDisplaySize(40, 40);
  goal.setTint(0x000055);

  stars = this.physics.add.group();

  for (let i = 0; i < TOTAL_STARS; i++) {
    let x,
      y,
      valid = false;
    while (!valid) {
      x = Phaser.Math.Between(60, 740);
      y = Phaser.Math.Between(60, 540);
      let testRect = new Phaser.Geom.Rectangle(x - 20, y - 20, 40, 40);
      let overlap = walls
        .getChildren()
        .some((w) => Phaser.Geom.Rectangle.Overlaps(testRect, w.getBounds()));
      if (!overlap && Phaser.Math.Distance.Between(x, y, 50, 50) > 100)
        valid = true;
    }
    stars.create(x, y, "block").setDisplaySize(12, 12).setTint(0x00ffff);
  }

  this.physics.add.collider(player, walls, resetPlayer, null, this);
  this.physics.add.overlap(player, stars, collectStar, null, this);
  this.physics.add.overlap(player, goal, checkWin, null, this);

  cursors = this.input.keyboard.createCursorKeys();
}

function createWall(scene, x, y, w, h) {
  let wall = walls.create(x, y, "block");
  wall.setDisplaySize(w, h);
  wall.setTint(0x0000ff);
  wall.refreshBody();
}

function update() {
  if (cursors.left.isDown && player.body.velocity.x <= 0) {
    player.setVelocity(-VELOCIDAD, 0);
  } else if (cursors.right.isDown && player.body.velocity.x >= 0) {
    player.setVelocity(VELOCIDAD, 0);
  } else if (cursors.up.isDown && player.body.velocity.y <= 0) {
    player.setVelocity(0, -VELOCIDAD);
  } else if (cursors.down.isDown && player.body.velocity.y >= 0) {
    player.setVelocity(0, VELOCIDAD);
  }
}

function collectStar(player, star) {
  star.disableBody(true, true);
  collectedCount++;
  player.setScale(player.scaleX * 1.2);
}

function resetPlayer() {
  player.setPosition(50, 50);
  player.setScale(1);
  player.setVelocity(VELOCIDAD, 0);
}

function checkWin() {
  if (collectedCount === TOTAL_STARS) {
    this.physics.pause();
    this.add.text(220, 280, "LABERINTO COMPLETADO", {
      fontSize: "32px",
      fill: "#00ffff",
    });
  }
}
